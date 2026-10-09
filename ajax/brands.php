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
            $searchQuery = " WHERE (marka_adi LIKE ?) ";
            $queryParams = ["%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['marka_adi', 'sira', 'durum', 'id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_markalar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_markalar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("SELECT * FROM i_markalar " . $searchQuery . $orderQuery . $limitQuery);
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Logo Yok</span>';
            if (!empty($row['marka_logo'])) {
                $resim_yolu = 'assets/images/markalar/thumb/' . htmlspecialchars($row['marka_logo']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Logo" width="50" height="50" style="object-fit:contain;" class="rounded shadow-sm">';
            }

            $data[] = [
                'id'             => $row['id'], 
                'durum'          => $row['durum'],
                'sira'           => $row['sira'],
                'marka_logo'     => $resim_goster, 
                'marka_adi'      => htmlspecialchars($row['marka_adi'] ?? ''),
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
        if(!empty($marka_adi)){
            $marka_url = sef_link($marka_adi);
            $resim_adi = null;

            if(isset($_FILES['marka_logo']) && $_FILES['marka_logo']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['marka_logo'], 'assets/images/markalar/', 'marka_');
            }

            $array = [
                "marka_adi"         => $marka_adi,
                "marka_url"         => $marka_url,
                "marka_logo"        => $resim_adi,
                "seo_title"         => !empty($seo_title) ? $seo_title : null,
                "seo_description"   => !empty($seo_description) ? $seo_description : null,
                "durum"             => 1
            ];

            $add = $db->prepare("INSERT INTO i_markalar SET
                marka_adi           = :marka_adi,
                marka_url           = :marka_url,
                marka_logo          = :marka_logo,
                seo_title           = :seo_title,
                seo_description     = :seo_description,
                durum               = :durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Marka başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. Aynı marka URL'si mevcut olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen Marka Adını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($marka_adi)){
            $marka_url = sef_link($marka_adi);
            $array = [
                "marka_adi"         => $marka_adi,
                "marka_url"         => $marka_url,
                "seo_title"         => !empty($seo_title) ? $seo_title : null,
                "seo_description"   => !empty($seo_description) ? $seo_description : null,
                "id"                => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT marka_logo FROM i_markalar WHERE id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['marka_logo'])){
                    resim_sil($eski['marka_logo'], 'assets/images/markalar/');
                }
                $resim_sql = "marka_logo = NULL,";
            } 
            elseif (isset($_FILES['marka_logo']) && $_FILES['marka_logo']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['marka_logo'], 'assets/images/markalar/', 'marka_');
                
                if($resim_adi){
                    $resim_sql = "marka_logo = :marka_logo,";
                    $array["marka_logo"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT marka_logo FROM i_markalar WHERE id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['marka_logo'])){
                        resim_sil($eski['marka_logo'], 'assets/images/markalar/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_markalar SET
                marka_adi           = :marka_adi,
                marka_url           = :marka_url,
                {$resim_sql}
                seo_title           = :seo_title,
                seo_description     = :seo_description
                WHERE id            = :id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Marka başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Marka Adını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_resim_sorgu = $db->prepare("SELECT id, marka_logo FROM i_markalar WHERE id = ?");
            $eski_resim_sorgu->execute([$id]);

            if($eski_resim_sorgu->rowCount()){
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['marka_logo'])){
                    resim_sil($eski['marka_logo'], 'assets/images/markalar/');
                }

                $delete = $db->prepare("DELETE FROM i_markalar WHERE id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Marka tamamen silinmiştir.","success",true);
                }else{
                    alert("Hata","Bir Sorun Oluştu Marka Silinememiştir.","error",true);
                }
            }
        }else{
            alert("Hata","Bir Sorun Oluştu","error");
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_markalar WHERE id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_markalar SET durum = ? WHERE id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Marka yayına alınmıştır." : "Marka yayından kaldırılmıştır.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_markalar SET sira = ? WHERE id = ?");
            
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