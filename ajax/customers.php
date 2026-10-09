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
            $searchQuery = " WHERE (musteri_adi LIKE ? OR unvan LIKE ? OR telefon LIKE ? OR gsm LIKE ? OR eposta LIKE ? OR vergi_no LIKE ?) ";
            $likeValue   = "%{$searchValue}%";
            $queryParams = [$likeValue, $likeValue, $likeValue, $likeValue, $likeValue, $likeValue];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC";
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'id';
            $allowedColumns = ['musteri_adi', 'unvan', 'telefon', 'eposta', 'kayit_tarihi', 'durum', 'id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_musteriler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_musteriler" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("SELECT * FROM i_musteriler" . $searchQuery . $orderQuery . $limitQuery);
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'id'           => $row['id'], 
                'durum'        => $row['durum'],
                'musteri_adi'  => htmlspecialchars($row['musteri_adi'] ?? ''),
                'unvan'        => !empty($row['unvan']) ? htmlspecialchars($row['unvan']) : '<span class="text-muted">-</span>',
                'telefon'      => !empty($row['telefon']) ? htmlspecialchars($row['telefon']) : (!empty($row['gsm']) ? htmlspecialchars($row['gsm']) : '-'),
                'eposta'       => !empty($row['eposta']) ? htmlspecialchars($row['eposta']) : '-',
                'kayit_tarihi' => tarih($row['kayit_tarihi']) 
            ];
        }

        $response = [
            "draw"            => $draw,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => $data
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType == "Add") {

        if(!empty($musteri_adi)){
            
            $resim_adi = null;
            if(isset($_FILES['musteri_resim']) && $_FILES['musteri_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['musteri_resim'], 'assets/images/musteriler/', 'musteri_');
            }

            $face_descriptor = null;
            if (isset($temp_id) && !empty($temp_id)) {
                $stmtFace = $db->prepare("SELECT face_descriptor FROM i_canli_tespitler WHERE id = ?");
                $stmtFace->execute([$temp_id]);
                $face_descriptor = $stmtFace->fetchColumn();
            }

            $array = [
                "musteri_tipi"    => !empty($musteri_tipi) ? $musteri_tipi : "bireysel",
                "musteri_adi"     => $musteri_adi,
                "unvan"           => !empty($unvan) ? $unvan : "",
                "yetkili_kisi"    => !empty($yetkili_kisi) ? $yetkili_kisi : "",
                "eposta"          => $eposta,
                "telefon"         => $telefon ?? '',
                "gsm"             => $gsm,
                "il_id"           => $il_id ?? 0,
                "ilce_id"         => $ilce_id ?? 0,
                "fatura_adresi"   => $fatura_adresi ?? '',
                "sevk_adresi"     => $sevk_adresi ?? '',
                "vergi_dairesi"   => !empty($vergi_dairesi) ? $vergi_dairesi : "",
                "vergi_no"        => $vergi_no ?? '',
                "bakiye"          => $bakiye ?? 0,
                "para_birimi"     => $para_birimi ?? 'TL',
                "musteri_resim"   => !empty($resim_adi) ? $resim_adi : "",
                "face_descriptor" => $face_descriptor, // Yüz vektörünü diziye ekledik
                "durum"           => 1
            ];

            $add = $db->prepare("INSERT INTO i_musteriler SET
                musteri_tipi    = :musteri_tipi,
                musteri_adi     = :musteri_adi,
                unvan           = :unvan,
                yetkili_kisi    = :yetkili_kisi,
                eposta          = :eposta,
                telefon         = :telefon,
                gsm             = :gsm,
                il_id           = :il_id,
                ilce_id         = :ilce_id,
                fatura_adresi   = :fatura_adresi,
                sevk_adresi     = :sevk_adresi,
                vergi_dairesi   = :vergi_dairesi,
                vergi_no        = :vergi_no,
                bakiye          = :bakiye,
                para_birimi     = :para_birimi,
                musteri_resim   = :musteri_resim,
                face_descriptor = :face_descriptor,
                durum           = :durum");
            
            $insertSuccess = $add->execute($array);

            if($insertSuccess){
                $yeniMusteriId = $db->lastInsertId();

                if (!empty($temp_id)) {
                    $updTemp = $db->prepare("UPDATE i_canli_tespitler SET durum = 'eslendi', musteri_id = ? WHERE id = ?");
                    $updTemp->execute([$yeniMusteriId, $temp_id]);

                    $stmtZiyaret = $db->prepare("INSERT INTO i_ziyaretler (musteri_id, ziyaret_tipi, ziyaret_tarihi, aciklama, durum) VALUES (?, ?, NOW(), ?, ?)");
                    $stmtZiyaret->execute([$yeniMusteriId, 'Yüz Tanıma Tespiti', 'Müşteri profili sisteme eklendi / kaydedildi.', '1']);
                }

                bildirimEkle($db, "Yeni Müşteri Eklendi", "{$musteri_adi} sisteme yeni müşteri olarak kaydedildi.", null, "info", "musteriler");

                alert("Başarılı","Müşteri hesabı, fotoğrafı ve yüz tanıma verisi başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu daha sonra tekrar deneyiniz.","error");
            }
        }else{
            alert("Uyarı","Lütfen zorunlu alanları boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($musteri_tipi) && !empty($musteri_adi)){

            $array = [
                "musteri_tipi"    => $musteri_tipi,
                "musteri_adi"     => $musteri_adi,
                "unvan"           => !empty($unvan) ? $unvan : "",
                "yetkili_kisi"    => $yetkili_kisi,
                "eposta"          => $eposta,
                "telefon"         => $telefon,
                "gsm"             => $gsm,
                "il_id"           => $il_id,
                "ilce_id"         => $ilce_id,
                "fatura_adresi"   => $fatura_adresi,
                "sevk_adresi"     => $sevk_adresi,
                "vergi_dairesi"   => !empty($vergi_dairesi) ? $vergi_dairesi : "",
                "vergi_no"        => $vergi_no,
                "bakiye"          => $bakiye,
                "para_birimi"     => $para_birimi,
                "id"              => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT musteri_resim FROM i_musteriler WHERE id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['musteri_resim'])){
                    resim_sil($eski['musteri_resim'], 'assets/images/musteriler/');
                }
                $resim_sql = "musteri_resim = NULL,";
            } 
            elseif (isset($_FILES['musteri_resim']) && $_FILES['musteri_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['musteri_resim'], 'assets/images/musteriler/', 'musteri_', '1200', '180', '180');
                
                if($resim_adi){
                    $resim_sql = "musteri_resim = :musteri_resim,";
                    $array["musteri_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT musteri_resim FROM i_musteriler WHERE id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['musteri_resim'])){
                        resim_sil($eski['musteri_resim'], 'assets/images/musteriler/');
                    }
                }
            }

            $sqlUpdate = "UPDATE i_musteriler SET
                musteri_tipi    = :musteri_tipi,
                musteri_adi     = :musteri_adi,
                unvan           = :unvan,
                yetkili_kisi    = :yetkili_kisi,
                eposta          = :eposta,
                telefon         = :telefon,
                gsm             = :gsm,
                il_id           = :il_id,
                ilce_id         = :ilce_id,
                fatura_adresi   = :fatura_adresi,
                sevk_adresi     = :sevk_adresi,
                vergi_dairesi   = :vergi_dairesi,
                vergi_no        = :vergi_no,
                bakiye          = :bakiye,
                {$resim_sql}
                para_birimi     = :para_birimi
                WHERE id        = :id";

            $add = $db->prepare($sqlUpdate);
            $add->execute($array);

            if($add){

                sistemLogEkle($db, 'UPDATE', 'Müşteriler', "Müşteri Bilgileri Güncellenmiştir Müşteri ID: {$value} ");

                alert("Başarılı","Müşteri bilgileri ve fotoğrafı başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu daha sonra tekrar deneyiniz.","error");
            }
        }else{
            alert("Uyarı","Lütfen boş bırakmayınız.","warning");
        }
    }

    $aktifPersonel = $_SESSION['uye_ad_soyad'] ?? 'Yönetici'; 


    if ($postType == "AddNote") {
        $yeniNotMetni = trim($_POST['not_metni'] ?? '');

        if (!empty($yeniNotMetni)) {
            $stmtMusteri = $db->prepare("SELECT notlar FROM i_musteriler WHERE id = ?");
            $stmtMusteri->execute([$value]);
            $mevcutVeri = $stmtMusteri->fetchColumn();

            $notlarDizi = [];
            
            if (!empty($mevcutVeri)) {
                $decoded = json_decode($mevcutVeri, true);
                if (is_array($decoded)) {
                    $notlarDizi = $decoded;
                } else {
                    $notlarDizi[] = [
                        'id' => uniqid(),
                        'metin' => $mevcutVeri,
                        'ekleyen' => 'Sistem / Eski Not',
                        'tarih' => '-'
                    ];
                }
            }

            array_unshift($notlarDizi, [
                'id' => uniqid(),
                'metin' => $yeniNotMetni,
                'ekleyen' => $aktifPersonel,
                'tarih' => date('Y-m-d H:i:s')
            ]);

            $jsonNotlar = json_encode($notlarDizi, JSON_UNESCAPED_UNICODE);
            
            $upd = $db->prepare("UPDATE i_musteriler SET notlar = ? WHERE id = ?");
            $upd->execute([$jsonNotlar, $value]);

            if($upd){
                alert("Başarılı","Müşteri notu başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu daha sonra tekrar deneyiniz.","error");
            }

            exit;
        }
    }

    if ($postType == "deleteNote") {
        $silinecekId = $_POST['note_id'] ?? '';
        if (!empty($silinecekId) && !empty($value)) {
            $stmtMusteri = $db->prepare("SELECT notlar FROM i_musteriler WHERE id = ?");
            $stmtMusteri->execute([$value]);
            $mevcutVeri = $stmtMusteri->fetchColumn();

            $upd = false;
            if (!empty($mevcutVeri)) {
                $notlarDizi = json_decode($mevcutVeri, true);
                if (is_array($notlarDizi)) {
                    $notlarDizi = array_values(array_filter($notlarDizi, function($n) use ($silinecekId) {
                        return ($n['id'] ?? '') !== $silinecekId;
                    }));

                    $jsonNotlar = json_encode($notlarDizi, JSON_UNESCAPED_UNICODE);
                   
                    $stmtUpd = $db->prepare("UPDATE i_musteriler SET notlar = ? WHERE id = ?");
                    $upd = $stmtUpd->execute([$jsonNotlar, $value]);
                }
            }

            if($upd){
                alert("Başarılı","Müşteri notu başarıyla silinmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu daha sonra tekrar deneyiniz.","error");
            }
            exit;
        }
    }

    if ($postType == "updateVipStatus") {

        if (!empty($value)) {
            $upd = $db->prepare("UPDATE i_musteriler SET vip_durum = ? WHERE id = ?");
            $success = $upd->execute([$status, $value]);

            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => 'VIP durumu başarıyla güncellendi.',
                    'vip_durum' => $status
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Veritabanı güncelleme hatası.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Müşteri ID eksik.'
            ]);
        }
        exit;
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT id FROM i_musteriler WHERE id = ?");
            $kontrol->execute([$id]);

            if($kontrol->rowCount()){
                $delete = $db->prepare("DELETE FROM i_musteriler WHERE id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Müşteri hesabı başarıyla silinmiştir.","success",true);
                }else{
                    alert("Hata","Bir sorun oluştu, silinemedi.","error",true);
                }
            } else {
                alert("Hata","Silinmek istenen müşteri bulunamadı.","error");
            }
        }else{
            alert("Hata","Bir Sorun Oluştu","error");
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_musteriler WHERE id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $mevcut_durum = $cek["durum"];
                $yeni_durum = ($mevcut_durum == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_musteriler SET durum = ? WHERE id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Müşteri Hesabı Yayından Alınmıştır." : "Müşteri Hesabı Yayından Kaldırılmıştır.";
                    alert("Başarılı", $mesaj, "success", true);
                } else {
                    alert("Hata","Durum güncellenemedi.","error",true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_musteriler SET sira = ? WHERE id = ?");
            
            $basarili = true;
            foreach ($siralamaDizisi as $index => $id) {
                $yeniSira = intval($index) + 1;
                $sonuc = $stmt->execute([$yeniSira, intval($id)]);
                
                if (!$sonuc) {
                    $basarili = false;
                    break;
                }
            }

            if ($basarili) {
                alert("Başarılı", "Sıralama başarıyla güncellendi.", "success", true);
            } else {
                alert("Hata", "Sıralama güncellenirken bir sorun oluştu.", "error");
            }
        } else {
            alert("Hata", "Geçersiz sıralama verisi.", "error");
        }
    }
}else{
    header("Location:".URL."404");
}
?>