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
            $searchQuery = " WHERE (u.urun_adi LIKE ? OR u.stok_kodu LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY u.sira ASC, u.urun_id DESC"; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'urun_id';
            $allowedColumns = ['stok_kodu', 'urun_adi', 'urun_fiyat', 'urun_stok', 'eklenme_tarihi', 'durum', 'urun_id', 'id'];
            
            if ($columnName === 'id') $columnName = 'urun_id';

            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY u.{$columnName} {$sortDir} ";
            }
        }

        $limitQuery = ($length != -1) ? " LIMIT {$start}, {$length} " : "";

        $totalQuery = $db->query("SELECT COUNT(urun_id) as total FROM i_urunler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(u.urun_id) as total FROM i_urunler u" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT u.*, k.kategori_adi, m.marka_adi 
            FROM i_urunler u 
            LEFT JOIN i_kategoriler k ON u.urun_kategori = k.id 
            LEFT JOIN i_markalar m ON u.marka_id = m.id 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Resim Yok</span>';
            if (!empty($row['kapak_resmi'])) {
                $resim_yolu = 'assets/images/urunler/thumb/' . htmlspecialchars($row['kapak_resmi']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Ürün" width="50" height="50" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'id'             => $row['urun_id'], 
                'durum'          => $row['durum'],
                'sira'           => $row['sira'],
                'kapak_resmi'    => $resim_goster,
                'stok_kodu'      => htmlspecialchars($row['stok_kodu'] ?? ''),
                'urun_adi'       => htmlspecialchars($row['urun_adi'] ?? ''),
                'kategori_adi'   => !empty($row['kategori_adi']) ? htmlspecialchars($row['kategori_adi']) : '-',
                'urun_fiyat'     => number_format($row['urun_fiyat'], 2, ',', '.') . ' ' . $row['para_birimi'],
                'urun_stok'      => $row['urun_stok'] . ' ' . $row['stok_birimi'],
                'eklenme_tarihi' => tarih($row['eklenme_tarihi']) 
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["draw" => $draw, "recordsTotal" => intval($recordsTotal), "recordsFiltered" => intval($recordsFiltered), "data" => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType == "Add") {
        if(!empty($urun_adi) && !empty($stok_kodu)){

            $urun_url = sef_link($urun_adi);
            $resim_adi = null;

            if(isset($_FILES['kapak_resmi']) && $_FILES['kapak_resmi']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['kapak_resmi'], 'assets/images/urunler/', 'urun_');
            }

            $array = [
                "stok_kodu"       => $stok_kodu,
                "urun_adi"        => $urun_adi,
                "urun_url"        => $urun_url,
                "urun_kategori"   => !empty($urun_kategori) ? intval($urun_kategori) : 0,
                "marka_id"        => !empty($marka_id) ? intval($marka_id) : 0,
                "alis_fiyati"     => !empty($alis_fiyati) ? $alis_fiyati : 0.00,
                "urun_fiyat"      => !empty($urun_fiyat) ? $urun_fiyat : 0.00,
                "urun_indirim"    => !empty($urun_indirim) ? $urun_indirim : 0.00,
                "urun_kdv"        => !empty($urun_kdv) ? intval($urun_kdv) : 20,
                "para_birimi"     => !empty($para_birimi) ? $para_birimi : 'TRY',
                "urun_stok"       => !empty($urun_stok) ? intval($urun_stok) : 0,
                "stok_birimi"     => !empty($stok_birimi) ? $stok_birimi : 'Adet',
                "kapak_resmi"     => $resim_adi,
                "kisa_aciklama"   => !empty($kisa_aciklama) ? $kisa_aciklama : null,
                "urun_aciklama"   => !empty($urun_aciklama) ? $urun_aciklama : null,
                "seo_title"       => !empty($seo_title) ? $seo_title : null,
                "seo_description" => !empty($seo_description) ? $seo_description : null,
                "durum"           => isset($durum) ? 1 : 0,
                "vitrin"          => isset($vitrin) ? 1 : 0,
                "yeni_urun"       => isset($yeni_urun) ? 1 : 0
            ];

            $add = $db->prepare("INSERT INTO i_urunler SET
                stok_kodu       = :stok_kodu,
                urun_adi        = :urun_adi,
                urun_url        = :urun_url,
                urun_kategori   = :urun_kategori,
                marka_id        = :marka_id,
                alis_fiyati     = :alis_fiyati,
                urun_fiyat      = :urun_fiyat,
                urun_indirim    = :urun_indirim,
                urun_kdv        = :urun_kdv,
                para_birimi     = :para_birimi,
                urun_stok       = :urun_stok,
                stok_birimi     = :stok_birimi,
                kapak_resmi     = :kapak_resmi,
                kisa_aciklama   = :kisa_aciklama,
                urun_aciklama   = :urun_aciklama,
                seo_title       = :seo_title,
                seo_description = :seo_description,
                durum           = :durum,
                vitrin          = :vitrin,
                yeni_urun       = :yeni_urun");
            
            $kontrol = $add->execute($array);

            if($kontrol){
                $son_urun_id = $db->lastInsertId();

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
                        $galeri_resim_adi = resim_yukle($tek_dosya, 'assets/images/urunler/', 'urun_galeri_');
                        if($galeri_resim_adi){
                            $db->prepare("INSERT INTO i_urun_resimler SET urun_id = ?, resim = ?, sira = ?")->execute([$son_urun_id, $galeri_resim_adi, $i]);
                        }
                    }
                }
                alert("Başarılı","Ürün başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. Aynı Stok Kodu kullanılmış olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen zorunlu alanları doldurunuz.","warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($urun_adi) && !empty($stok_kodu)){
            
            $urun_url = sef_link($urun_adi);
            $array = [
                "stok_kodu"       => $stok_kodu,
                "urun_adi"        => $urun_adi,
                "urun_url"        => $urun_url,
                "urun_kategori"   => !empty($urun_kategori) ? intval($urun_kategori) : 0,
                "marka_id"        => !empty($marka_id) ? intval($marka_id) : 0,
                "alis_fiyati"     => !empty($alis_fiyati) ? $alis_fiyati : 0.00,
                "urun_fiyat"      => !empty($urun_fiyat) ? $urun_fiyat : 0.00,
                "urun_indirim"    => !empty($urun_indirim) ? $urun_indirim : 0.00,
                "urun_kdv"        => !empty($urun_kdv) ? intval($urun_kdv) : 20,
                "para_birimi"     => !empty($para_birimi) ? $para_birimi : 'TRY',
                "urun_stok"       => !empty($urun_stok) ? intval($urun_stok) : 0,
                "stok_birimi"     => !empty($stok_birimi) ? $stok_birimi : 'Adet',
                "kisa_aciklama"   => !empty($kisa_aciklama) ? $kisa_aciklama : null,
                "urun_aciklama"   => !empty($urun_aciklama) ? $urun_aciklama : null,
                "seo_title"       => !empty($seo_title) ? $seo_title : null,
                "seo_description" => !empty($seo_description) ? $seo_description : null,
                "durum"           => isset($durum) ? 1 : 0,
                "vitrin"          => isset($vitrin) ? 1 : 0,
                "yeni_urun"       => isset($yeni_urun) ? 1 : 0,
                "urun_id"         => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT kapak_resmi FROM i_urunler WHERE urun_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                if(!empty($eski['kapak_resmi'])) resim_sil($eski['kapak_resmi'], 'assets/images/urunler/');
                $resim_sql = "kapak_resmi = NULL,";
            } 
            // 2. Yeni Kapak Resmi Yüklendiyse (En öncelikli)
            elseif (isset($_FILES['kapak_resmi']) && $_FILES['kapak_resmi']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['kapak_resmi'], 'assets/images/urunler/', 'urun_');
                if($resim_adi){
                    $resim_sql = "kapak_resmi = :kapak_resmi,";
                    $array["kapak_resmi"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT kapak_resmi FROM i_urunler WHERE urun_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    if(!empty($eski['kapak_resmi'])) resim_sil($eski['kapak_resmi'], 'assets/images/urunler/');
                }
            }
            elseif (isset($kapak_yap) && !empty($kapak_yap)) {
                if (!isset($galeri_sil) || !in_array($kapak_yap, $galeri_sil)) {
                    $gk_sec = $db->prepare("SELECT resim FROM i_urun_resimler WHERE id = ?");
                    $gk_sec->execute([$kapak_yap]);
                    $gk_res = $gk_sec->fetch();
                    
                    if ($gk_res && !empty($gk_res['resim'])) {
                        $yeni_kapak_adi = $gk_res['resim'];
                        
                        $eski_k_sec = $db->prepare("SELECT kapak_resmi FROM i_urunler WHERE urun_id = ?");
                        $eski_k_sec->execute([$value]);
                        $eski_k_res = $eski_k_sec->fetch();
                        
                        if (!empty($eski_k_res['kapak_resmi'])) {
                            $db->prepare("INSERT INTO i_urun_resimler (urun_id, resim) VALUES (?, ?)")->execute([$value, $eski_k_res['kapak_resmi']]);
                        }

                        $resim_sql = "kapak_resmi = :kapak_resmi,";
                        $array["kapak_resmi"] = $yeni_kapak_adi;

                        $db->prepare("DELETE FROM i_urun_resimler WHERE id = ?")->execute([$kapak_yap]);
                    }
                }
            }

            $update = $db->prepare("UPDATE i_urunler SET
                stok_kodu       = :stok_kodu,
                urun_adi        = :urun_adi,
                urun_url        = :urun_url,
                urun_kategori   = :urun_kategori,
                marka_id        = :marka_id,
                alis_fiyati     = :alis_fiyati,
                urun_fiyat      = :urun_fiyat,
                urun_indirim    = :urun_indirim,
                urun_kdv        = :urun_kdv,
                para_birimi     = :para_birimi,
                urun_stok       = :urun_stok,
                stok_birimi     = :stok_birimi,
                {$resim_sql}
                kisa_aciklama   = :kisa_aciklama,
                urun_aciklama   = :urun_aciklama,
                seo_title       = :seo_title,
                seo_description = :seo_description,
                durum           = :durum,
                vitrin          = :vitrin,
                yeni_urun       = :yeni_urun
                WHERE urun_id   = :urun_id");
            
            $kontrol = $update->execute($array);

            if($kontrol){
                
                if (isset($galeri_sil) && is_array($galeri_sil)) {
                    foreach ($galeri_sil as $g_id) {
                        $gsil_sec = $db->prepare("SELECT resim FROM i_urun_resimler WHERE id = ?");
                        $gsil_sec->execute([$g_id]);
                        $gsil_res = $gsil_sec->fetch();
                        
                        if ($gsil_res && !empty($gsil_res['resim'])) {
                            resim_sil($gsil_res['resim'], 'assets/images/urunler/');
                            $db->prepare("DELETE FROM i_urun_resimler WHERE id = ?")->execute([$g_id]);
                        }
                    }
                }

                if (isset($galeri_sira) && is_array($galeri_sira)) {
                    foreach ($galeri_sira as $index => $g_id) {
                        $db->prepare("UPDATE i_urun_resimler SET sira = ? WHERE id = ?")->execute([$index, $g_id]);
                    }
                }

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

                        $galeri_resim_adi = resim_yukle($tek_dosya, 'assets/images/urunler/', 'urun_galeri_');
                        if($galeri_resim_adi){
                            $db->prepare("INSERT INTO i_urun_resimler SET urun_id = ?, resim = ?")->execute([$value, $galeri_resim_adi]);
                        }
                    }
                }
                
                alert("Başarılı","Ürün başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. Stok Kodu çakışması olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen zorunlu alanları doldurunuz.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_kapak = $db->prepare("SELECT kapak_resmi FROM i_urunler WHERE urun_id = ?");
            $eski_kapak->execute([$id]);
            $kapak = $eski_kapak->fetch();
            
            if(!empty($kapak['kapak_resmi'])){
                resim_sil($kapak['kapak_resmi'], 'assets/images/urunler/');
            }

            $galeri_resimler = $db->prepare("SELECT resim FROM i_urun_resimler WHERE urun_id = ?");
            $galeri_resimler->execute([$id]);
            
            foreach($galeri_resimler as $gresim){
                if(!empty($gresim['resim'])){
                    resim_sil($gresim['resim'], 'assets/images/urunler/');
                }
            }
            $db->prepare("DELETE FROM i_urun_resimler WHERE urun_id = ?")->execute([$id]);

            $delete = $db->prepare("DELETE FROM i_urunler WHERE urun_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Ürün ve tüm görselleri başarıyla silinmiştir.","success",true);
            }else{
                alert("Hata","Ürün silinemedi.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_urunler WHERE urun_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_urunler SET durum = ? WHERE urun_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    alert("Başarılı", "Ürün durumu güncellendi.", "success", true);
                }
            }
        }
    }


    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_urunler SET sira = ? WHERE urun_id = ?");
            
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