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
            $searchQuery = " WHERE (sss_soru LIKE ?) ";
            $queryParams = ["%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, sss_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['sss_soru', 'sira', 'sss_durum', 'sss_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(sss_id) as total FROM i_sss");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(sss_id) as total FROM i_sss" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_sss 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'sss_id'           => $row['sss_id'], 
                'sss_durum'        => $row['sss_durum'],
                'sira'             => $row['sira'],
                'sss_soru'         => htmlspecialchars($row['sss_soru'] ?? ''),
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
        if(!empty($sss_soru) && !empty($sss_cevap)){
            $array = [
                "sss_soru"  => $sss_soru,
                "sss_cevap" => $sss_cevap,
                "sss_durum" => 1
            ];

            $add = $db->prepare("INSERT INTO i_sss SET
                sss_soru    = :sss_soru,
                sss_cevap   = :sss_cevap,
                sss_durum   = :sss_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Soru başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Soru ve Cevap alanlarını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($sss_soru) && !empty($sss_cevap)){
            $array = [
                "sss_soru"  => $sss_soru,
                "sss_cevap" => $sss_cevap,
                "sss_id"    => $value
            ];

            $update = $db->prepare("UPDATE i_sss SET
                sss_soru    = :sss_soru,
                sss_cevap   = :sss_cevap
                WHERE sss_id = :sss_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Soru başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Soru ve Cevap alanlarını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $delete = $db->prepare("DELETE FROM i_sss WHERE sss_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Soru silinmiştir.","success",true);
            }else{
                alert("Hata","Soru silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT sss_durum FROM i_sss WHERE sss_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["sss_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_sss SET sss_durum = ? WHERE sss_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Soru yayına alınmıştır." : "Soru gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_sss SET sira = ? WHERE sss_id = ?");
            
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
        }
    }
}
?>