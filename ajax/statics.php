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
            $searchQuery = " WHERE (baslik LIKE ? OR sayfa_url LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['baslik', 'sayfa_url', 'sira', 'durum', 'id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_sabit_sayfalar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_sabit_sayfalar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_sabit_sayfalar 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Resim Yok</span>';
            if (!empty($row['sayfa_resim'])) {
                $resim_yolu = 'assets/images/systems/' . htmlspecialchars($row['sayfa_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Sabit Sayfa Resim" width="60" height="40" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'id'             => $row['id'], 
                'durum'          => $row['durum'],
                'sira'           => $row['sira'],
                'sayfa_resim'    => $resim_goster,
                'baslik'         => htmlspecialchars($row['baslik'] ?? ''),
                'sayfa_url'      => '<span class="badge bg-light text-dark">'.htmlspecialchars($row['sayfa_url'] ?? '').'</span>',
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
        if(!empty($baslik)){
            $sayfa_url = !empty($sayfa_url) ? sef_link($sayfa_url) : sef_link($baslik);
            $resim_dosya = null;

            if(isset($_FILES['sayfa_resim']) && $_FILES['sayfa_resim']['error'] == 0){
                $resim_dosya = resim_yukle($_FILES['sayfa_resim'], 'assets/images/systems/', 'sabit_sayfa_');
            }

            $array = [
                "sayfa_url"   => $sayfa_url,
                "baslik"      => $baslik,
                "title"       => !empty($title) ? $title : null,
                "description" => !empty($description) ? $description : null,
                "sayfa_resim" => $resim_dosya,
                "durum"       => 1
            ];

            $add = $db->prepare("INSERT INTO i_sabit_sayfalar SET
                sayfa_url   = :sayfa_url,
                baslik      = :baslik,
                title       = :title,
                description = :description,
                sayfa_resim = :sayfa_resim,
                durum       = :durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Sabit sayfa başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Sayfa Başlığını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($baslik)){
            $sayfa_url = !empty($sayfa_url) ? sef_link($sayfa_url) : sef_link($baslik);
            $array = [
                "sayfa_url"   => $sayfa_url,
                "baslik"      => $baslik,
                "title"       => !empty($title) ? $title : null,
                "description" => !empty($description) ? $description : null,
                "id"          => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_sorgu = $db->prepare("SELECT sayfa_resim FROM i_sabit_sayfalar WHERE id = ?");
                $eski_sorgu->execute([$value]);
                $eski = $eski_sorgu->fetch();
                
                if(!empty($eski['sayfa_resim'])){
                    resim_sil($eski['sayfa_resim'], 'assets/images/systems/');
                }
                $resim_sql = "sayfa_resim = NULL,";
            } 
            elseif (isset($_FILES['sayfa_resim']) && $_FILES['sayfa_resim']['error'] == 0) {
                $resim_dosya = resim_yukle($_FILES['sayfa_resim'], 'assets/images/systems/', 'sabit_sayfa_');
                
                if($resim_dosya){
                    $resim_sql = "sayfa_resim = :sayfa_resim,";
                    $array["sayfa_resim"] = $resim_dosya;
                    
                    $eski_sorgu = $db->prepare("SELECT sayfa_resim FROM i_sabit_sayfalar WHERE id = ?");
                    $eski_sorgu->execute([$value]);
                    $eski = $eski_sorgu->fetch();
                    
                    if(!empty($eski['sayfa_resim'])){
                        resim_sil($eski['sayfa_resim'], 'assets/images/systems/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_sabit_sayfalar SET
                sayfa_url         = :sayfa_url,
                baslik            = :baslik,
                title             = :title,
                description       = :description,
                {$resim_sql}
                guncelleme_tarihi = NOW()
                WHERE id          = :id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Sabit sayfa başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Sayfa Başlığını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT id FROM i_sabit_sayfalar WHERE id = ?");
            $kontrol->execute([$id]);

            if($kontrol->rowCount()){
                $eski_sorgu = $db->prepare("SELECT sayfa_resim FROM i_sabit_sayfalar WHERE id = ?");
                $eski_sorgu->execute([$id]);
                $eski = $eski_sorgu->fetch();

                if(!empty($eski['sayfa_resim'])){
                    resim_sil($eski['sayfa_resim'], 'assets/images/systems/');
                }

                $delete = $db->prepare("DELETE FROM i_sabit_sayfalar WHERE id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Sabit sayfa silinmiştir.","success",true);
                }else{
                    alert("Hata","Sabit sayfa silinememiştir.","error",true);
                }
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_sabit_sayfalar WHERE id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_sabit_sayfalar SET durum = ? WHERE id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Sabit sayfa yayına alınmıştır." : "Sabit sayfa gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_sabit_sayfalar SET sira = ? WHERE id = ?");
            
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