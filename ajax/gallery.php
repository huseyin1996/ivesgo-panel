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

            if (mb_stripos('fotoğraf', $arama) !== false || mb_stripos('fotograf', $arama) !== false || $arama === '1') {
                $tipKarsilik = '1';
            } elseif (mb_stripos('video', $arama) !== false || $arama === '2') {
                $tipKarsilik = '2';
            } elseif (mb_stripos('referans', $arama) !== false || mb_stripos('logo', $arama) !== false || $arama === '3') {
                $tipKarsilik = '3';
            } elseif (mb_stripos('sertifika', $arama) !== false || $arama === '4') {
                $tipKarsilik = '4';
            }

            if (!empty($tipKarsilik)) {
                $searchQuery = " WHERE (galeri_baslik LIKE ? OR galeri_tip = ?) ";
                $queryParams = ["%{$searchValue}%", $tipKarsilik];
            } else {
                $searchQuery = " WHERE (galeri_baslik LIKE ?) ";
                $queryParams = ["%{$searchValue}%"];
            }
        }

        $orderQuery = " ORDER BY sira ASC, galeri_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['galeri_baslik', 'galeri_tip', 'sira', 'galeri_durum', 'galeri_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(galeri_id) as total FROM i_galeri");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(galeri_id) as total FROM i_galeri" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_galeri 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Görsel Yok</span>';
            if (!empty($row['galeri_resim'])) {
                $resim_yolu = 'assets/images/galeri/thumb/' . htmlspecialchars($row['galeri_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Galeri" width="60" height="40" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            switch ($row['galeri_tip']) {
                case '1':
                    $tipBadge = '<span class="badge bg-primary">Fotoğraf Galeri</span>';
                    break;
                case '2':
                    $tipBadge = '<span class="badge bg-success">Video Galeri</span>';
                    break;
                case '3':
                    $tipBadge = '<span class="badge bg-warning text-dark">Referans Logo</span>';
                    break;
                case '4':
                    $tipBadge = '<span class="badge bg-secondary">Sertifika</span>';
                    break;
                default:
                    $tipBadge = '<span class="badge bg-info">Diğer</span>';
                    break;
            }

            $data[] = [
                'galeri_id'        => $row['galeri_id'], 
                'galeri_durum'     => $row['galeri_durum'],
                'sira'             => $row['sira'],
                'galeri_resim'     => $resim_goster,
                'galeri_baslik'    => htmlspecialchars($row['galeri_baslik'] ?? ''),
                'galeri_tip'       => $tipBadge,
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
        if(!empty($galeri_baslik)){
            $resim_adi = null;

            if(isset($_FILES['galeri_resim']) && $_FILES['galeri_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['galeri_resim'], 'assets/images/galeri/', 'galeri_');
            }

            $array = [
                "galeri_baslik"   => $galeri_baslik,
                "galeri_tip"      => !empty($galeri_tip) ? intval($galeri_tip) : 1,
                "galeri_resim"    => $resim_adi,
                "video_url"       => !empty($video_url) ? $video_url : null,
                "galeri_durum"    => 1
            ];

            $add = $db->prepare("INSERT INTO i_galeri SET
                galeri_baslik     = :galeri_baslik,
                galeri_tip        = :galeri_tip,
                galeri_resim      = :galeri_resim,
                video_url         = :video_url,
                galeri_durum      = :galeri_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Galeri öğesi başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Başlık alanını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($galeri_baslik)){
            $array = [
                "galeri_baslik"   => $galeri_baslik,
                "galeri_tip"      => !empty($galeri_tip) ? intval($galeri_tip) : 1,
                "video_url"       => !empty($video_url) ? $video_url : null,
                "galeri_id"       => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT galeri_resim FROM i_galeri WHERE galeri_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['galeri_resim'])){
                    resim_sil($eski['galeri_resim'], 'assets/images/galeri/');
                }
                $resim_sql = "galeri_resim = NULL,";
            } 
            elseif (isset($_FILES['galeri_resim']) && $_FILES['galeri_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['galeri_resim'], 'assets/images/galeri/', 'galeri_');
                
                if($resim_adi){
                    $resim_sql = "galeri_resim = :galeri_resim,";
                    $array["galeri_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT galeri_resim FROM i_galeri WHERE galeri_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['galeri_resim'])){
                        resim_sil($eski['galeri_resim'], 'assets/images/galeri/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_galeri SET
                galeri_baslik     = :galeri_baslik,
                galeri_tip        = :galeri_tip,
                {$resim_sql}
                video_url         = :video_url,
                WHERE galeri_id   = :galeri_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Galeri öğesi güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Başlık alanını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_resim_sorgu = $db->prepare("SELECT galeri_resim FROM i_galeri WHERE galeri_id = ?");
            $eski_resim_sorgu->execute([$id]);
            $eski = $eski_resim_sorgu->fetch();

            if(!empty($eski['galeri_resim'])){
                resim_sil($eski['galeri_resim'], 'assets/images/galeri/');
            }

            $delete = $db->prepare("DELETE FROM i_galeri WHERE galeri_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Öğe silinmiştir.","success",true);
            }else{
                alert("Hata","Öğe silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT galeri_durum FROM i_galeri WHERE galeri_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["galeri_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_galeri SET galeri_durum = ? WHERE galeri_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Öğe yayına alınmıştır." : "Öğe gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_galeri SET sira = ? WHERE galeri_id = ?");
            
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