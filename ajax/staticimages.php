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
            $searchQuery = " WHERE (resim_baslik LIKE ? OR resim_adi LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['resim_baslik', 'resim_adi', 'sira', 'durum', 'id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_sabit_resimler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_sabit_resimler" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_sabit_resimler 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Resim Yok</span>';
            if (!empty($row['resim'])) {
                $resim_yolu = 'assets/images/systems/' . htmlspecialchars($row['resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Sabit Resim" width="60" height="40" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'id'             => $row['id'], 
                'durum'          => $row['durum'],
                'sira'           => $row['sira'],
                'resim'          => $resim_goster,
                'resim_baslik'   => htmlspecialchars($row['resim_baslik'] ?? ''),
                'resim_adi'      => '<span class="badge bg-light text-dark">'.htmlspecialchars($row['resim_adi'] ?? '').'</span>',
                'eklenme_tarihi' => tarih($row['eklenme_tarihi']) 
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
        if(!empty($resim_baslik)){
            $resim_adi = sef_link($resim_baslik);
            $resim_dosya = null;

            if(isset($_FILES['resim']) && $_FILES['resim']['error'] == 0){
                $resim_dosya = resim_yukle($_FILES['resim'], 'assets/images/systems/', 'sabit_');
            }

            $array = [
                "resim_baslik" => $resim_baslik,
                "resim_adi"    => $resim_adi,
                "resim"        => $resim_dosya,
                "durum"        => 1
            ];

            $add = $db->prepare("INSERT INTO i_sabit_resimler SET
                resim_baslik = :resim_baslik,
                resim_adi    = :resim_adi,
                resim        = :resim,
                durum        = :durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Sabit resim başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Resim Başlığını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($resim_baslik)){
            $resim_adi = sef_link($resim_baslik);
            $array = [
                "resim_baslik" => $resim_baslik,
                "resim_adi"    => $resim_adi,
                "id"           => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_sorgu = $db->prepare("SELECT resim FROM i_sabit_resimler WHERE id = ?");
                $eski_sorgu->execute([$value]);
                $eski = $eski_sorgu->fetch();
                
                if(!empty($eski['resim'])){
                    resim_sil($eski['resim'], 'assets/images/systems/');
                }
                $resim_sql = "resim = NULL,";
            } 
            elseif (isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
                $resim_dosya = resim_yukle($_FILES['resim'], 'assets/images/systems/', 'sabit_');
                
                if($resim_dosya){
                    $resim_sql = "resim = :resim,";
                    $array["resim"] = $resim_dosya;
                    
                    $eski_sorgu = $db->prepare("SELECT resim FROM i_sabit_resimler WHERE id = ?");
                    $eski_sorgu->execute([$value]);
                    $eski = $eski_sorgu->fetch();
                    
                    if(!empty($eski['resim'])){
                        resim_sil($eski['resim'], 'assets/images/systems/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_sabit_resimler SET
                resim_baslik = :resim_baslik,
                resim_adi    = :resim_adi,
                {$resim_sql}
                guncelleme_tarihi = NOW()
                WHERE id     = :id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Sabit resim başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Resim Başlığını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT id FROM i_sabit_resimler WHERE id = ?");
            $kontrol->execute([$id]);

            if($kontrol->rowCount()){
                $eski_sorgu = $db->prepare("SELECT resim FROM i_sabit_resimler WHERE id = ?");
                $eski_sorgu->execute([$id]);
                $eski = $eski_sorgu->fetch();

                if(!empty($eski['resim'])){
                    resim_sil($eski['resim'], 'assets/images/systems/');
                }

                $delete = $db->prepare("DELETE FROM i_sabit_resimler WHERE id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Sabit resim silinmiştir.","success",true);
                }else{
                    alert("Hata","Sabit resim silinememiştir.","error",true);
                }
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_sabit_resimler WHERE id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_sabit_resimler SET durum = ? WHERE id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Sabit resim yayına alınmıştır." : "Sabit resim gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_sabit_resimler SET sira = ? WHERE id = ?");
            
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