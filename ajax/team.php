<?php
$data = [];

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
            $searchQuery = " WHERE (ekip_ad_soyad LIKE ? OR ekip_unvan LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, ekip_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['ekip_ad_soyad', 'ekip_unvan', 'sira', 'ekip_durum', 'ekip_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(ekip_id) as total FROM i_ekibimiz");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(ekip_id) as total FROM i_ekibimiz" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_ekibimiz 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Fotoğraf Yok</span>';
            if (!empty($row['ekip_resim'])) {
                $resim_yolu = 'assets/images/ekip/thumb/' . htmlspecialchars($row['ekip_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Ekip" width="40" height="40" style="object-fit:cover;" class="rounded-circle shadow-sm">';
            }

            $data[] = [
                'ekip_id'          => $row['ekip_id'], 
                'ekip_durum'       => $row['ekip_durum'],
                'sira'             => $row['sira'],
                'ekip_resim'       => $resim_goster,
                'ekip_ad_soyad'    => htmlspecialchars($row['ekip_ad_soyad'] ?? ''),
                'ekip_unvan'       => htmlspecialchars($row['ekip_unvan'] ?? '-'),
                'olusturma_tarihi' => tarih($row['olusturma_tarihi']) 
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
        if(!empty($ekip_ad_soyad)){
            $ekip_url = sef_link($ekip_ad_soyad);
            $resim_adi = null;

            if(isset($_FILES['ekip_resim']) && $_FILES['ekip_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['ekip_resim'], 'assets/images/ekip/', 'ekip_');
            }

            $array = [
                "ekip_ad_soyad"    => $ekip_ad_soyad,
                "ekip_unvan"       => !empty($ekip_unvan) ? $ekip_unvan : null,
                "ekip_url"         => $ekip_url,
                "ekip_telefon"     => !empty($ekip_telefon) ? $ekip_telefon : null,
                "ekip_eposta"      => !empty($ekip_eposta) ? $ekip_eposta : null,
                "ekip_kisa"        => !empty($ekip_kisa) ? $ekip_kisa : null,
                "ekip_icerik"      => !empty($ekip_icerik) ? $ekip_icerik : '',
                "ekip_resim"       => $resim_adi,
                "ekip_durum"       => 1
            ];

            $add = $db->prepare("INSERT INTO i_ekibimiz SET
                ekip_ad_soyad    = :ekip_ad_soyad,
                ekip_unvan       = :ekip_unvan,
                ekip_url         = :ekip_url,
                ekip_telefon     = :ekip_telefon,
                ekip_eposta      = :ekip_eposta,
                ekip_kisa        = :ekip_kisa,
                ekip_icerik      = :ekip_icerik,
                ekip_resim       = :ekip_resim,
                ekip_durum       = :ekip_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Ekip üyesi başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Ad Soyad alanını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($ekip_ad_soyad)){
            $ekip_url = sef_link($ekip_ad_soyad);
            $array = [
                "ekip_ad_soyad"    => $ekip_ad_soyad,
                "ekip_unvan"       => !empty($ekip_unvan) ? $ekip_unvan : null,
                "ekip_url"         => $ekip_url,
                "ekip_telefon"     => !empty($ekip_telefon) ? $ekip_telefon : null,
                "ekip_eposta"      => !empty($ekip_eposta) ? $ekip_eposta : null,
                "ekip_kisa"        => !empty($ekip_kisa) ? $ekip_kisa : null,
                "ekip_icerik"      => !empty($ekip_icerik) ? $ekip_icerik : '',
                "ekip_id"          => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT ekip_resim FROM i_ekibimiz WHERE ekip_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['ekip_resim'])){
                    resim_sil($eski['ekip_resim'], 'assets/images/ekip/');
                }
                $resim_sql = "ekip_resim = NULL,";
            } 
            elseif (isset($_FILES['ekip_resim']) && $_FILES['ekip_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['ekip_resim'], 'assets/images/ekip/', 'ekip_');
                
                if($resim_adi){
                    $resim_sql = "ekip_resim = :ekip_resim,";
                    $array["ekip_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT ekip_resim FROM i_ekibimiz WHERE ekip_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['ekip_resim'])){
                        resim_sil($eski['ekip_resim'], 'assets/images/ekip/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_ekibimiz SET
                ekip_ad_soyad    = :ekip_ad_soyad,
                ekip_unvan       = :ekip_unvan,
                ekip_url         = :ekip_url,
                ekip_telefon     = :ekip_telefon,
                ekip_eposta      = :ekip_eposta,
                ekip_kisa        = :ekip_kisa,
                {$resim_sql}
                ekip_icerik      = :ekip_icerik
                WHERE ekip_id    = :ekip_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Ekip üyesi güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Ad Soyad alanını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_resim_sorgu = $db->prepare("SELECT ekip_resim FROM i_ekibimiz WHERE ekip_id = ?");
            $eski_resim_sorgu->execute([$id]);
            $eski = $eski_resim_sorgu->fetch();

            if(!empty($eski['ekip_resim'])){
                resim_sil($eski['ekip_resim'], 'assets/images/ekip/');
            }

            $delete = $db->prepare("DELETE FROM i_ekibimiz WHERE ekip_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Kayıt silinmiştir.","success",true);
            }else{
                alert("Hata","Kayıt silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT ekip_durum FROM i_ekibimiz WHERE ekip_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["ekip_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_ekibimiz SET ekip_durum = ? WHERE ekip_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Kayıt yayına alınmıştır." : "Kayıt gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_ekibimiz SET sira = ? WHERE ekip_id = ?");
            
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
                alert("Başarılı", "Sıralama güncellendi.", "success", true);
            } else {
                alert("Hata", "Sıralama güncellenirken hata oluştu.", "error");
            }
        }
    }
}
?>