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
            $searchQuery = " WHERE (kategori_adi LIKE ?) ";
            $queryParams = ["%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['kategori_adi', 'ust_id', 'sira', 'durum', 'id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_kategoriler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_kategoriler" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT k.*, u.kategori_adi as ust_kategori_adi 
            FROM i_kategoriler k 
            LEFT JOIN i_kategoriler u ON k.ust_id = u.id 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Resim Yok</span>';
            if (!empty($row['kategori_resim'])) {
                $resim_yolu = 'assets/images/kategoriler/thumb/' . htmlspecialchars($row['kategori_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Kategori" width="50" height="50" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'id'             => $row['id'], 
                'durum'          => $row['durum'],
                'sira'           => $row['sira'],
                'kategori_resim' => $resim_goster,
                'kategori_adi'   => htmlspecialchars($row['kategori_adi'] ?? ''),
                'ust_id'         => !empty($row['ust_id']) ? htmlspecialchars($row['ust_kategori_adi']) : '<span class="badge bg-info">Ana Kategori</span>',
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
        if(!empty($kategori_adi)){
            $kategori_url = sef_link($kategori_adi);
            $resim_adi = null;

            if(isset($_FILES['kategori_resim']) && $_FILES['kategori_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['kategori_resim'], 'assets/images/kategoriler/', 'kat_');
            }

            $array = [
                "ust_id"            => !empty($ust_id) ? intval($ust_id) : 0,
                "kategori_adi"      => $kategori_adi,
                "kategori_url"      => $kategori_url,
                "kategori_aciklama" => !empty($kategori_aciklama) ? $kategori_aciklama : null,
                "kategori_resim"    => $resim_adi,
                "kategori_icon"     => !empty($kategori_icon) ? $kategori_icon : null,
                "seo_title"         => !empty($seo_title) ? $seo_title : null,
                "seo_description"   => !empty($seo_description) ? $seo_description : null,
                "durum"             => 1
            ];

            $add = $db->prepare("INSERT INTO i_kategoriler SET
                ust_id              = :ust_id,
                kategori_adi        = :kategori_adi,
                kategori_url        = :kategori_url,
                kategori_aciklama   = :kategori_aciklama,
                kategori_resim      = :kategori_resim,
                kategori_icon       = :kategori_icon,
                seo_title           = :seo_title,
                seo_description     = :seo_description,
                durum               = :durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Kategori başarıyla kaydedilmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu. Aynı kategori URL'si mevcut olabilir.","error");
            }
        }else{
            alert("Uyarı","Lütfen Kategori Adını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($kategori_adi)){
            $kategori_url = sef_link($kategori_adi);
            $array = [
                "ust_id"            => !empty($ust_id) ? intval($ust_id) : 0,
                "kategori_adi"      => $kategori_adi,
                "kategori_url"      => $kategori_url,
                "kategori_aciklama" => !empty($kategori_aciklama) ? $kategori_aciklama : null,
                "kategori_icon"     => !empty($kategori_icon) ? $kategori_icon : null,
                "seo_title"         => !empty($seo_title) ? $seo_title : null,
                "seo_description"   => !empty($seo_description) ? $seo_description : null,
                "id"                => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT kategori_resim FROM i_kategoriler WHERE id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['kategori_resim'])){
                    resim_sil($eski['kategori_resim'], 'assets/images/kategoriler/');
                }
                $resim_sql = "kategori_resim = NULL,";
            } 
            elseif (isset($_FILES['kategori_resim']) && $_FILES['kategori_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['kategori_resim'], 'assets/images/kategoriler/', 'kat_');
                
                if($resim_adi){
                    $resim_sql = "kategori_resim = :kategori_resim,";
                    $array["kategori_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT kategori_resim FROM i_kategoriler WHERE id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['kategori_resim'])){
                        resim_sil($eski['kategori_resim'], 'assets/images/kategoriler/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_kategoriler SET
                ust_id              = :ust_id,
                kategori_adi        = :kategori_adi,
                kategori_url        = :kategori_url,
                {$resim_sql}
                kategori_aciklama   = :kategori_aciklama,
                kategori_icon       = :kategori_icon,
                seo_title           = :seo_title,
                seo_description     = :seo_description
                WHERE id            = :id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Kategori başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Kategori Adını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT id FROM i_kategoriler WHERE id = ?");
            $kontrol->execute([$id]);

            if($kontrol->rowCount()){
                $eski_resim_sorgu = $db->prepare("SELECT kategori_resim FROM i_kategoriler WHERE id = ?");
                $eski_resim_sorgu->execute([$id]);
                $eski = $eski_resim_sorgu->fetch();

                if(!empty($eski['kategori_resim'])){
                    resim_sil($eski['kategori_resim'], 'assets/images/kategoriler/');
                }

                $alt_guncelle = $db->prepare("UPDATE i_kategoriler SET ust_id = 0 WHERE ust_id = ?");
                $alt_guncelle->execute([$id]);

                $delete = $db->prepare("DELETE FROM i_kategoriler WHERE id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Kategori silinmiştir. Alt kategoriler Ana Kategori yapıldı.","success",true);
                }else{
                    alert("Hata","Bir Sorun Oluştu Kategori Silinememiştir.","error",true);
                }
            }
        }else{
            alert("Hata","Bir Sorun Oluştu","error");
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_kategoriler WHERE id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_kategoriler SET durum = ? WHERE id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Kategori yayına alınmıştır." : "Kategori yayından kaldırılmıştır.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }


    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_kategoriler SET sira = ? WHERE id = ?");
            
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