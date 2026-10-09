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
            $searchQuery = " WHERE (yorum_ad_soyad LIKE ? OR yorum_unvan LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, yorum_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['yorum_ad_soyad', 'yorum_unvan', 'yorum_puan', 'sira', 'yorum_durum', 'yorum_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(yorum_id) as total FROM i_yorumlar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(yorum_id) as total FROM i_yorumlar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_yorumlar 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Fotoğraf Yok</span>';
            if (!empty($row['yorum_resim'])) {
                $resim_yolu = 'assets/images/yorumlar/thumb/' . htmlspecialchars($row['yorum_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Yorum" width="40" height="40" style="object-fit:cover;" class="rounded-circle shadow-sm">';
            }

            // Yıldız Puanı Görselleştirme
            $puan = intval($row['yorum_puan']);
            $yildizHTML = '<span class="text-warning">';
            for ($i = 1; $i <= 5; $i++) {
                $yildizHTML .= ($i <= $puan) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
            }
            $yildizHTML .= '</span>';

            $data[] = [
                'yorum_id'         => $row['yorum_id'], 
                'yorum_durum'      => $row['yorum_durum'],
                'sira'             => $row['sira'],
                'yorum_resim'      => $resim_goster,
                'yorum_ad_soyad'   => htmlspecialchars($row['yorum_ad_soyad'] ?? ''),
                'yorum_unvan'      => htmlspecialchars($row['yorum_unvan'] ?? '-'),
                'yorum_puan'       => $yildizHTML,
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
        if(!empty($yorum_ad_soyad) && !empty($yorum_metin)){
            $resim_adi = null;

            if(isset($_FILES['yorum_resim']) && $_FILES['yorum_resim']['error'] == 0){
                $resim_adi = resim_yukle($_FILES['yorum_resim'], 'assets/images/yorumlar/', 'yorum_');
            }

            $array = [
                "yorum_ad_soyad" => $yorum_ad_soyad,
                "yorum_unvan"    => !empty($yorum_unvan) ? $yorum_unvan : null,
                "yorum_metin"    => $yorum_metin,
                "yorum_puan"     => !empty($yorum_puan) ? intval($yorum_puan) : 5,
                "yorum_resim"    => $resim_adi,
                "yorum_durum"    => 1
            ];

            $add = $db->prepare("INSERT INTO i_yorumlar SET
                yorum_ad_soyad   = :yorum_ad_soyad,
                yorum_unvan      = :yorum_unvan,
                yorum_metin      = :yorum_metin,
                yorum_puan       = :yorum_puan,
                yorum_resim      = :yorum_resim,
                yorum_durum      = :yorum_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Yorum başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Ad Soyad ve Yorum metnini boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($yorum_ad_soyad) && !empty($yorum_metin)){
            $array = [
                "yorum_ad_soyad" => $yorum_ad_soyad,
                "yorum_unvan"    => !empty($yorum_unvan) ? $yorum_unvan : null,
                "yorum_metin"    => $yorum_metin,
                "yorum_puan"     => !empty($yorum_puan) ? intval($yorum_puan) : 5,
                "yorum_id"       => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT yorum_resim FROM i_yorumlar WHERE yorum_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['yorum_resim'])){
                    resim_sil($eski['yorum_resim'], 'assets/images/yorumlar/');
                }
                $resim_sql = "yorum_resim = NULL,";
            } 
            elseif (isset($_FILES['yorum_resim']) && $_FILES['yorum_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['yorum_resim'], 'assets/images/yorumlar/', 'yorum_');
                
                if($resim_adi){
                    $resim_sql = "yorum_resim = :yorum_resim,";
                    $array["yorum_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT yorum_resim FROM i_yorumlar WHERE yorum_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['yorum_resim'])){
                        resim_sil($eski['yorum_resim'], 'assets/images/yorumlar/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_yorumlar SET
                yorum_ad_soyad   = :yorum_ad_soyad,
                yorum_unvan      = :yorum_unvan,
                yorum_metin      = :yorum_metin,
                {$resim_sql}
                yorum_puan       = :yorum_puan
                WHERE yorum_id   = :yorum_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Yorum güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Ad Soyad ve Yorum metnini boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $eski_resim_sorgu = $db->prepare("SELECT yorum_resim FROM i_yorumlar WHERE yorum_id = ?");
            $eski_resim_sorgu->execute([$id]);
            $eski = $eski_resim_sorgu->fetch();

            if(!empty($eski['yorum_resim'])){
                resim_sil($eski['yorum_resim'], 'assets/images/yorumlar/');
            }

            $delete = $db->prepare("DELETE FROM i_yorumlar WHERE yorum_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Yorum silinmiştir.","success",true);
            }else{
                alert("Hata","Yorum silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT yorum_durum FROM i_yorumlar WHERE yorum_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["yorum_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_yorumlar SET yorum_durum = ? WHERE yorum_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Yorum yayına alınmıştır." : "Yorum gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_yorumlar SET sira = ? WHERE yorum_id = ?");
            
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