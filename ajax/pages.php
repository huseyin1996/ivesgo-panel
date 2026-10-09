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
            $arama = mb_strtolower(trim($searchValue), 'UTF-8');
            $tipKarsilik = '';

            if (mb_stripos('kurumsal', $arama) !== false || $arama === '1') {
                $tipKarsilik = '1';
            } elseif (mb_stripos('hizmet', $arama) !== false || $arama === '2') {
                $tipKarsilik = '2';
            } elseif (mb_stripos('çözüm', $arama) !== false || mb_stripos('cozum', $arama) !== false || $arama === '3') {
                $tipKarsilik = '3';
            } elseif (mb_stripos('sözleşme', $arama) !== false || mb_stripos('sozlesme', $arama) !== false || $arama === '4') {
                $tipKarsilik = '4';
            }

            if (!empty($tipKarsilik)) {
                $searchQuery = " WHERE (sayfa_baslik LIKE ? OR sayfa_tip = ?) ";
                $queryParams = ["%{$searchValue}%", $tipKarsilik];
            } else {
                $searchQuery = " WHERE (sayfa_baslik LIKE ?) ";
                $queryParams = ["%{$searchValue}%"];
            }
        }

        $orderQuery = " ORDER BY sira ASC, sayfa_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['sayfa_baslik', 'sayfa_tip', 'sira', 'sayfa_durum', 'sayfa_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(sayfa_id) as total FROM i_sayfalar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(sayfa_id) as total FROM i_sayfalar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_sayfalar 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Resim Yok</span>';
            if (!empty($row['sayfa_resim'])) {
                $resim_yolu = 'assets/images/sayfalar/' . htmlspecialchars($row['sayfa_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Sayfa Resmi" width="50" height="50" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            switch ($row['sayfa_tip']) {
                case '1': $tipBadge = '<span class="badge bg-primary">Kurumsal</span>'; break;
                case '2': $tipBadge = '<span class="badge bg-success">Hizmet</span>'; break;
                case '3': $tipBadge = '<span class="badge bg-warning text-dark">Çözüm</span>'; break;
                case '4': $tipBadge = '<span class="badge bg-secondary">Sözleşme</span>'; break;
                default:  $tipBadge = '<span class="badge bg-info">Diğer</span>'; break;
            }

            $data[] = [
                'sayfa_id'         => $row['sayfa_id'], 
                'sayfa_durum'      => $row['sayfa_durum'],
                'sira'             => $row['sira'],
                'sayfa_resim'      => $resim_goster,
                'sayfa_baslik'     => htmlspecialchars($row['sayfa_baslik'] ?? ''),
                'sayfa_tip'        => $tipBadge,
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
        if(!empty($sayfa_baslik)){
            $sayfa_url = sef_link($sayfa_baslik);
            $resim_adi = null;

            if(isset($_FILES['sayfa_resim']) && $_FILES['sayfa_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['sayfa_resim'], 'assets/images/sayfalar/', 'sayfa_');
            }

            $ozellikler_json = null;
            if(isset($_POST['ozellik_baslik']) && is_array($_POST['ozellik_baslik'])) {
                $tempOzellikler = [];
                foreach($_POST['ozellik_baslik'] as $idx => $baslikVal) {
                    if(!empty(trim($baslikVal))) {
                        $tempOzellikler[] = [
                            'baslik'   => trim($baslikVal),
                            'aciklama' => trim($_POST['ozellik_aciklama'][$idx] ?? '')
                        ];
                    }
                }
                if(!empty($tempOzellikler)) {
                    $ozellikler_json = json_encode($tempOzellikler, JSON_UNESCAPED_UNICODE);
                }
            }

            $array = [
                "sayfa_baslik"      => $sayfa_baslik,
                "sayfa_url"         => $sayfa_url,
                "sayfa_tip"         => !empty($sayfa_tip) ? intval($sayfa_tip) : 1,
                "sayfa_kisa"        => !empty($sayfa_kisa) ? $sayfa_kisa : null,
                "sayfa_icerik"      => !empty($sayfa_icerik) ? $sayfa_icerik : '',
                "sayfa_resim"       => $resim_adi,
                "sayfa_ozellikler"  => $ozellikler_json,
                "sayfa_title"       => !empty($sayfa_title) ? $sayfa_title : null,
                "sayfa_description" => !empty($sayfa_description) ? $sayfa_description : null,
                "sayfa_durum"       => isset($sayfa_durum) ? 1 : 0
            ];

            $add = $db->prepare("INSERT INTO i_sayfalar SET
                sayfa_baslik        = :sayfa_baslik,
                sayfa_url           = :sayfa_url,
                sayfa_tip           = :sayfa_tip,
                sayfa_kisa          = :sayfa_kisa,
                sayfa_icerik        = :sayfa_icerik,
                sayfa_resim         = :sayfa_resim,
                sayfa_ozellikler    = :sayfa_ozellikler,
                sayfa_title         = :sayfa_title,
                sayfa_description   = :sayfa_description,
                sayfa_durum         = :sayfa_durum");
            $kontrol = $add->execute($array);
            $yeni_sayfa_id = $db->lastInsertId();

            if($kontrol && $yeni_sayfa_id){
                if(isset($_FILES['galeri']) && !empty($_FILES['galeri']['name'][0])){
                    $dosya_sayisi = count($_FILES['galeri']['name']);
                    for($i = 0; $i < $dosya_sayisi; $i++){
                        $tek_dosya = [
                            'name'     => $_FILES['galeri']['name'][$i],
                            'type'     => $_FILES['galeri']['type'][$i],
                            'tmp_name' => $_FILES['galeri']['tmp_name'][$i],
                            'error'    => $_FILES['galeri']['error'][$i],
                            'size'     => $_FILES['galeri']['size'][$i]
                        ];
                        $galeri_resim_adi = resim_yukle($tek_dosya, 'assets/images/sayfalar/', 'sayfa_galeri_');
                        if($galeri_resim_adi){
                            $db->prepare("INSERT INTO i_sayfa_resimler SET sayfa_id = ?, resim = ?, sira = ?")->execute([$yeni_sayfa_id, $galeri_resim_adi, $i]);
                        }
                    }
                }
                alert("Başarılı","Sayfa başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. Aynı sayfa URL'si mevcut olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen Sayfa Başlığını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($sayfa_baslik)){
            $sayfa_url = sef_link($sayfa_baslik);
            
            $array = [
                "sayfa_baslik"      => $sayfa_baslik,
                "sayfa_url"         => $sayfa_url,
                "sayfa_tip"         => !empty($sayfa_tip) ? intval($sayfa_tip) : 1,
                "sayfa_kisa"        => !empty($sayfa_kisa) ? $sayfa_kisa : null,
                "sayfa_icerik"      => !empty($sayfa_icerik) ? $sayfa_icerik : '',
                "sayfa_title"       => !empty($sayfa_title) ? $sayfa_title : null,
                "sayfa_description" => !empty($sayfa_description) ? $sayfa_description : null,
                "sayfa_durum"       => isset($sayfa_durum) ? 1 : 0,
                "sayfa_id"          => $value
            ];

            // Özellikler / Sorular JSON Güncelleme
            $ozellikler_json = null;
            if(isset($_POST['ozellik_baslik']) && is_array($_POST['ozellik_baslik'])) {
                $tempOzellikler = [];
                foreach($_POST['ozellik_baslik'] as $idx => $baslikVal) {
                    if(!empty(trim($baslikVal))) {
                        $tempOzellikler[] = [
                            'baslik'   => trim($baslikVal),
                            'aciklama' => trim($_POST['ozellik_aciklama'][$idx] ?? '')
                        ];
                    }
                }
                if(!empty($tempOzellikler)) {
                    $ozellikler_json = json_encode($tempOzellikler, JSON_UNESCAPED_UNICODE);
                }
            }
            $array["sayfa_ozellikler"] = $ozellikler_json;

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT sayfa_resim FROM i_sayfalar WHERE sayfa_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                if(!empty($eski['sayfa_resim'])) resim_sil($eski['sayfa_resim'], 'assets/images/sayfalar/');
                $resim_sql = "sayfa_resim = NULL,";
            } 
            elseif (isset($_FILES['sayfa_resim']) && $_FILES['sayfa_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['sayfa_resim'], 'assets/images/sayfalar/', 'sayfa_');
                if($resim_adi){
                    $resim_sql = "sayfa_resim = :sayfa_resim,";
                    $array["sayfa_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT sayfa_resim FROM i_sayfalar WHERE sayfa_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    if(!empty($eski['sayfa_resim'])) resim_sil($eski['sayfa_resim'], 'assets/images/sayfalar/');
                }
            }
            // Galeriden Kapak Yapma (Eski kapak galeriye atılır, seçilen resim kapak olur)
            elseif (isset($kapak_yap) && !empty($kapak_yap)) {
                if (!isset($galeri_sil) || !in_array($kapak_yap, $galeri_sil)) {
                    $gk_sec = $db->prepare("SELECT resim FROM i_sayfa_resimler WHERE id = ?");
                    $gk_sec->execute([$kapak_yap]);
                    $gk_res = $gk_sec->fetch();
                    
                    if ($gk_res && !empty($gk_res['resim'])) {
                        $yeni_kapak_adi = $gk_res['resim'];
                        
                        $eski_k_sec = $db->prepare("SELECT sayfa_resim FROM i_sayfalar WHERE sayfa_id = ?");
                        $eski_k_sec->execute([$value]);
                        $eski_k_res = $eski_k_sec->fetch();
                        
                        // Eski kapak resmi boş değilse galeri tablosuna geri ekle (Takas / Yer değiştirme)
                        if (!empty($eski_k_res['sayfa_resim'])) {
                            $db->prepare("INSERT INTO i_sayfa_resimler (sayfa_id, resim, sira) VALUES (?, ?, 0)")->execute([$value, $eski_k_res['sayfa_resim']]);
                        }

                        $resim_sql = "sayfa_resim = :sayfa_resim,";
                        $array["sayfa_resim"] = $yeni_kapak_adi;

                        // Seçilen görsel galeriden kaldırılır
                        $db->prepare("DELETE FROM i_sayfa_resimler WHERE id = ?")->execute([$kapak_yap]);
                    }
                }
            }

            $update = $db->prepare("UPDATE i_sayfalar SET
                sayfa_baslik        = :sayfa_baslik,
                sayfa_url           = :sayfa_url,
                sayfa_tip           = :sayfa_tip,
                sayfa_kisa          = :sayfa_kisa,
                {$resim_sql}
                sayfa_icerik        = :sayfa_icerik,
                sayfa_ozellikler    = :sayfa_ozellikler,
                sayfa_title         = :sayfa_title,
                sayfa_description   = :sayfa_description,
                sayfa_durum         = :sayfa_durum,
                guncelleme_tarihi   = NOW()
                WHERE sayfa_id      = :sayfa_id");
            
            $kontrol = $update->execute($array);

            if($kontrol){
                
                // Galeri Resimlerini Silme
                if (isset($galeri_sil) && is_array($galeri_sil)) {
                    foreach ($galeri_sil as $g_id) {
                        $gsil_sec = $db->prepare("SELECT resim FROM i_sayfa_resimler WHERE id = ?");
                        $gsil_sec->execute([$g_id]);
                        $gsil_res = $gsil_sec->fetch();
                        
                        if ($gsil_res && !empty($gsil_res['resim'])) {
                            resim_sil($gsil_res['resim'], 'assets/images/sayfalar/');
                            $db->prepare("DELETE FROM i_sayfa_resimler WHERE id = ?")->execute([$g_id]);
                        }
                    }
                }

                // Galeri Sıralaması
                if (isset($galeri_sira) && is_array($galeri_sira)) {
                    foreach ($galeri_sira as $index => $g_id) {
                        $db->prepare("UPDATE i_sayfa_resimler SET sira = ? WHERE id = ?")->execute([$index, $g_id]);
                    }
                }

                // Yeni Galeri Resimleri Ekleme
                if(isset($_FILES['galeri']) && !empty($_FILES['galeri']['name'][0])){
                    $dosya_sayisi = count($_FILES['galeri']['name']);
                    
                    for($i = 0; $i < $dosya_sayisi; $i++){
                        $tek_dosya = [
                            'name'     => $_FILES['galeri']['name'][$i],
                            'type'     => $_FILES['galeri']['type'][$i],
                            'tmp_name' => $_FILES['galeri']['tmp_name'][$i],
                            'error'    => $_FILES['galeri']['error'][$i],
                            'size'     => $_FILES['galeri']['size'][$i]
                        ];

                        $galeri_resim_adi = resim_yukle($tek_dosya, 'assets/images/sayfalar/', 'sayfa_galeri_');
                        if($galeri_resim_adi){
                            $db->prepare("INSERT INTO i_sayfa_resimler SET sayfa_id = ?, resim = ?")->execute([$value, $galeri_resim_adi]);
                        }
                    }
                }
                
                alert("Başarılı","Sayfa başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. URL çakışması olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen zorunlu alanları doldurunuz.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_kapak = $db->prepare("SELECT sayfa_resim FROM i_sayfalar WHERE sayfa_id = ?");
            $eski_kapak->execute([$id]);
            $kapak = $eski_kapak->fetch();
            
            if(!empty($kapak['sayfa_resim'])){
                resim_sil($kapak['sayfa_resim'], 'assets/images/sayfalar/');
            }

            $galeri_resimler = $db->prepare("SELECT resim FROM i_sayfa_resimler WHERE sayfa_id = ?");
            $galeri_resimler->execute([$id]);
            
            foreach($galeri_resimler as $gresim){
                if(!empty($gresim['resim'])){
                    resim_sil($gresim['resim'], 'assets/images/sayfalar/');
                }
            }
            $db->prepare("DELETE FROM i_sayfa_resimler WHERE sayfa_id = ?")->execute([$id]);

            $delete = $db->prepare("DELETE FROM i_sayfalar WHERE sayfa_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Sayfa ve tüm görselleri başarıyla silinmiştir.","success",true);
            }else{
                alert("Hata","Sayfa silinemedi.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT sayfa_durum FROM i_sayfalar WHERE sayfa_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["sayfa_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_sayfalar SET sayfa_durum = ? WHERE sayfa_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    alert("Başarılı", "Sayfa durumu güncellendi.", "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_sayfalar SET sira = ? WHERE sayfa_id = ?");
            
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
}
?>