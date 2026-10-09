<?php

if(isset($_POST)){
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
            exit;
        }
    }

    if ($postType == "List") {
        $draw        = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $start       = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length      = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

        $columns = $_POST['columns'] ?? [];
        $searchQuery = "";
        $queryParams = [];

        if (!empty($searchValue)) {
            $searchQuery = " WHERE (uye_ad_soyad LIKE ? OR uye_kullanici_adi LIKE ? OR uye_eposta LIKE ?) ";
            $likeValue   = "%{$searchValue}%";
            $queryParams = [$likeValue, $likeValue, $likeValue];
        }

        $orderQuery = " ORDER BY uye_id DESC ";
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $columnName  = $columns[$columnIndex]['data'] ?? 'uye_id';
            $allowed     = ['uye_ad_soyad', 'uye_kullanici_adi', 'uye_eposta', 'uye_rutbe', 'uye_onay', 'uye_id'];
            if (in_array($columnName, $allowed)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = ($length != -1) ? " LIMIT {$start}, {$length} " : "";

        $totalQuery = $db->query("SELECT COUNT(uye_id) as total FROM i_uyeler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(uye_id) as total FROM i_uyeler" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("SELECT * FROM i_uyeler" . $searchQuery . $orderQuery . $limitQuery);
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($results as $row) {
            $resim = !empty($row['uye_resim']) && file_exists('assets/images/users/'.$row['uye_resim']) 
                 ? 'assets/images/users/'.$row['uye_resim'] 
                 : 'assets/images/resim-yok.png';

            $avatar = '<img src="'.$resim.'" width="40" height="40" style="object-fit:cover;" class="rounded-circle shadow-sm">';
            
            $onay_badge = ($row['uye_onay'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Pasif</span>';
            
            $rutbeler = [1 => 'Personel', 2 => 'Yönetici', 3 => 'Süper Admin'];
            $rutbe_adi = $rutbeler[$row['uye_rutbe']] ?? 'Personel';

            $data[] = [
                'id'                => $row['uye_id'], // İşlem butonları için gerekli primary key
                'uye_resim'         => $avatar,
                'uye_ad_soyad'      => htmlspecialchars($row['uye_ad_soyad']),
                'uye_kullanici_adi' => htmlspecialchars($row['uye_kullanici_adi']),
                'uye_eposta'        => htmlspecialchars($row['uye_eposta']),
                'uye_rutbe'         => '<span class="badge bg-info text-dark">'.$rutbe_adi.'</span>',
                'uye_onay'          => $onay_badge,
                'durum'             => intval($row['uye_onay']) // Durum butonunun anlık state alabilmesi için doğru veri (0 veya 1)
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["draw" => $draw, "recordsTotal" => intval($recordsTotal), "recordsFiltered" => intval($recordsFiltered), "data" => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType == "Add") {
        if(!empty($uye_ad_soyad) && !empty($uye_kullanici_adi) && !empty($uye_sifre)){
            
            $kontrol = $db->prepare("SELECT id FROM i_uyeler WHERE uye_kullanici_adi = ? OR uye_eposta = ?");
            $kontrol->execute([$uye_kullanici_adi, $uye_eposta]);
            if($kontrol->rowCount() > 0) {
                alert("Hata", "Bu kullanıcı adı veya e-posta adresi zaten kayıtlı.", "error");
                exit;
            }

            $resim_adi = null;
            if(isset($_FILES['uye_resim']) && $_FILES['uye_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['uye_resim'], '../assets/images/users/', 'user_');
            }

            $sifre_hash = password_hash($uye_sifre, PASSWORD_DEFAULT);
            $eski_sifreler_json = json_encode([$sifre_hash]);

            $izinlerDizi = $_POST['izinler'] ?? [];
            $izinlerJson = json_encode($izinlerDizi, JSON_UNESCAPED_UNICODE);


            $array = [
                "uye_ad_soyad"      => $uye_ad_soyad,
                "uye_kullanici_adi" => trim($uye_kullanici_adi),
                "uye_sifre"         => $sifre_hash,
                "eski_sifreler"     => $eski_sifreler_json,
                "uye_eposta"        => $uye_eposta,
                "uye_telefon"       => !empty($uye_telefon) ? $uye_telefon : null,
                "izinler"           => $izinlerJson,
                "uye_resim"         => $resim_adi,
                "uye_rutbe"         => intval($uye_rutbe ?? 1),
                "uye_bildirim"      => isset($uye_bildirim) ? 1 : 0,
                "uye_onay"          => isset($uye_onay) ? 1 : 0,
                "activate_code"     => md5(uniqid())
            ];

            $add = $db->prepare("INSERT INTO i_uyeler SET
                uye_ad_soyad      = :uye_ad_soyad,
                uye_kullanici_adi = :uye_kullanici_adi,
                uye_sifre         = :uye_sifre,
                eski_sifreler     = :eski_sifreler,
                uye_eposta        = :uye_eposta,
                uye_telefon       = :uye_telefon,
                izinler           = :izinler,
                uye_resim         = :uye_resim,
                uye_rutbe         = :uye_rutbe,
                uye_bildirim      = :uye_bildirim,
                uye_onay          = :uye_onay,
                activate_code     = :activate_code");
            
            if($add->execute($array)){
                alert("Başarılı", "Personel hesabı başarıyla oluşturuldu.", "success", true);
            } else {
                alert("Hata", "Kayıt sırasında bir sorun oluştu.", "error");
            }
        }else{
            alert("Uyarı", "Lütfen zorunlu alanları doldurunuz.", "warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($uye_ad_soyad)){
            
            $eski_data = $db->prepare("SELECT * FROM i_uyeler WHERE uye_id = ?");
            $eski_data->execute([$value]);
            $mevcut = $eski_data->fetch(PDO::FETCH_ASSOC);

            $izinlerDizi = $_POST['izinler'] ?? [];
            $izinlerJson = json_encode($izinlerDizi, JSON_UNESCAPED_UNICODE);

            $array = [
                "uye_ad_soyad"      => $uye_ad_soyad,
                "uye_kullanici_adi" => trim($uye_kullanici_adi),
                "uye_eposta"        => $uye_eposta,
                "uye_telefon"       => !empty($uye_telefon) ? $uye_telefon : null,
                "izinlerJson"       => $izinlerJson,
                "uye_rutbe"         => intval($uye_rutbe ?? 1),
                "uye_bildirim"      => isset($uye_bildirim) ? 1 : 0,
                "uye_onay"          => isset($uye_onay) ? 1 : 0,
                "uye_id"            => intval($value)
            ];

            $resim_sql = "";
            if(isset($_FILES['uye_resim']) && $_FILES['uye_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['uye_resim'], '../assets/images/users/', 'user_');
                if($resim_adi){
                    if(!empty($mevcut['uye_resim'])) @unlink('../assets/images/users/'.$mevcut['uye_resim']);
                    $resim_sql = "uye_resim = :uye_resim,";
                    $array["uye_resim"] = $resim_adi;
                }
            }

            $sifre_sql = "";
            if(!empty($uye_sifre)){
                $eski_hashler = json_decode($mevcut['eski_sifreler'] ?? '[]', true);
                
                $tekrar_eden = false;
                foreach($eski_hashler as $h) {
                    if(password_verify($uye_sifre, $h)) {
                        $tekrar_eden = true;
                        break;
                    }
                }

                if($tekrar_eden) {
                    alert("Uyarı", "Güvenlik gereği son kullanılan şifrelerinizden birini tekrar kullanamazsınız.", "warning");
                    exit;
                }

                $yeni_hash = password_hash($uye_sifre, PASSWORD_DEFAULT);
                array_unshift($eski_hashler, $yeni_hash);
                $eski_hashler = array_slice($eski_hashler, 0, 3);

                $sifre_sql = "uye_sifre = :uye_sifre, eski_sifreler = :eski_sifreler,";
                $array["uye_sifre"] = $yeni_hash;
                $array["eski_sifreler"] = json_encode($eski_hashler);
            }

            $update = $db->prepare("UPDATE i_uyeler SET
                uye_ad_soyad        = :uye_ad_soyad,
                uye_kullanici_adi   = :uye_kullanici_adi,
                {$sifre_sql}
                {$resim_sql}
                uye_eposta          = :uye_eposta,
                uye_telefon         = :uye_telefon,
                izinler             = :izinlerJson,
                uye_rutbe           = :uye_rutbe,
                uye_bildirim        = :uye_bildirim,
                uye_onay            = :uye_onay
                WHERE uye_id        = :uye_id");
            
            if($update->execute($array)){
                sistemLogEkle($db, 'UPDATE', 'PERSONEL', "Personel bilgileri güncellenmiştir. Personel Adı ve Soyadı : {$uye_ad_soyad}, ID {$value}");
                alert("Başarılı", "Personel bilgileri güncellendi.", "success", true);
            } else {
                alert("Hata", "Güncelleme yapılamadı.", "error");
            }
        }else{
            alert("Uyarı", "Zorunlu alanlar doldurulmalıdır.", "warning");
        }
    }

    // ONAY / DURUM DEĞİŞTİRME
    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT uye_onay FROM i_uyeler WHERE uye_id = ?");
            $kontrol->execute([$id]);
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni = ($cek["uye_onay"] == 1) ? 0 : 1;
                $db->prepare("UPDATE i_uyeler SET uye_onay = ? WHERE uye_id = ?")->execute([$yeni, $id]);
                alert("Başarılı", "Personel durumu güncellendi.", "success", true);
            }
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $resim_bul = $db->prepare("SELECT uye_resim FROM i_uyeler WHERE uye_id = ?");
            $resim_bul->execute([$id]);
            $r = $resim_bul->fetch();
            if(!empty($r['uye_resim'])) @unlink('../assets/images/users/'.$r['uye_resim']);

            $del = $db->prepare("DELETE FROM i_uyeler WHERE uye_id = ?");
            if($del->execute([$id])){
                alert("Başarılı", "Personel kaydı silindi.", "success", true);
            } else {
                alert("Hata", "Personel silinemedi.", "error", true);
            }
        }
    }
}
?>