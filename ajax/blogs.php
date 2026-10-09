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
            $searchQuery = " WHERE (blog_baslik LIKE ? OR blog_etiketler LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, blog_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['blog_baslik', 'sira', 'blog_durum', 'blog_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(blog_id) as total FROM i_bloglar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(blog_id) as total FROM i_bloglar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_bloglar 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Görsel Yok</span>';
            if (!empty($row['blog_resim'])) {
                $resim_yolu = 'assets/images/blog/thumb/' . htmlspecialchars($row['blog_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Blog" width="60" height="40" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'blog_id'          => $row['blog_id'], 
                'blog_durum'       => $row['blog_durum'],
                'sira'             => $row['sira'],
                'blog_resim'       => $resim_goster,
                'blog_baslik'      => htmlspecialchars($row['blog_baslik'] ?? ''),
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
        if(!empty($blog_baslik)){
            $blog_url = sef_link($blog_baslik);
            $resim_adi = null;

            if(isset($_FILES['blog_resim']) && $_FILES['blog_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['blog_resim'], 'assets/images/blog/', 'blog_');
            }

            $array = [
                "blog_baslik"      => $blog_baslik,
                "blog_url"         => $blog_url,
                "blog_kisa"        => !empty($blog_kisa) ? $blog_kisa : null,
                "blog_icerik"      => !empty($blog_icerik) ? $blog_icerik : '',
                "blog_resim"       => $resim_adi,
                "blog_etiketler"   => !empty($blog_etiketler) ? $blog_etiketler : null,
                "blog_title"       => !empty($blog_title) ? $blog_title : null,
                "blog_description" => !empty($blog_description) ? $blog_description : null,
                "blog_durum"       => 1
            ];

            $add = $db->prepare("INSERT INTO i_bloglar SET
                blog_baslik      = :blog_baslik,
                blog_url         = :blog_url,
                blog_kisa        = :blog_kisa,
                blog_icerik      = :blog_icerik,
                blog_resim       = :blog_resim,
                blog_etiketler   = :blog_etiketler,
                blog_title       = :blog_title,
                blog_description = :blog_description,
                blog_durum       = :blog_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Blog yazısı başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu (Aynı URL mevcut olabilir).","error");
            }
        }else{
            alert("Uyarı","Lütfen Blog Başlığını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($blog_baslik)){
            $blog_url = sef_link($blog_baslik);
            $array = [
                "blog_baslik"      => $blog_baslik,
                "blog_url"         => $blog_url,
                "blog_kisa"        => !empty($blog_kisa) ? $blog_kisa : null,
                "blog_icerik"      => !empty($blog_icerik) ? $blog_icerik : '',
                "blog_etiketler"   => !empty($blog_etiketler) ? $blog_etiketler : null,
                "blog_title"       => !empty($blog_title) ? $blog_title : null,
                "blog_description" => !empty($blog_description) ? $blog_description : null,
                "blog_id"          => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT blog_resim FROM i_bloglar WHERE blog_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['blog_resim'])){
                    resim_sil($eski['blog_resim'], 'assets/images/blog/');
                }
                $resim_sql = "blog_resim = NULL,";
            } 
            elseif (isset($_FILES['blog_resim']) && $_FILES['blog_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['blog_resim'], 'assets/images/blog/', 'blog_');
                
                if($resim_adi){
                    $resim_sql = "blog_resim = :blog_resim,";
                    $array["blog_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT blog_resim FROM i_bloglar WHERE blog_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['blog_resim'])){
                        resim_sil($eski['blog_resim'], 'assets/images/blog/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_bloglar SET
                blog_baslik      = :blog_baslik,
                blog_url         = :blog_url,
                blog_kisa        = :blog_kisa,
                {$resim_sql}
                blog_icerik      = :blog_icerik,
                blog_etiketler   = :blog_etiketler,
                blog_title       = :blog_title,
                blog_description = :blog_description
                WHERE blog_id    = :blog_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Blog yazısı güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Blog Başlığını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_resim_sorgu = $db->prepare("SELECT blog_resim FROM i_bloglar WHERE blog_id = ?");
            $eski_resim_sorgu->execute([$id]);
            $eski = $eski_resim_sorgu->fetch();

            if(!empty($eski['blog_resim'])){
                resim_sil($eski['blog_resim'], 'assets/images/blog/');
            }

            $delete = $db->prepare("DELETE FROM i_bloglar WHERE blog_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Blog yazısı silinmiştir.","success",true);
            }else{
                alert("Hata","Yazı silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT blog_durum FROM i_bloglar WHERE blog_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["blog_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_bloglar SET blog_durum = ? WHERE blog_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Blog yayına alınmıştır." : "Blog taslağa çevrilmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_bloglar SET sira = ? WHERE blog_id = ?");
            
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