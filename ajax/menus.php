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
            $searchQuery = " WHERE (m.menu_baslik LIKE ? OR m.menu_url LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY m.sira ASC, m.menu_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['menu_baslik', 'menu_url', 'sira', 'menu_durum', 'menu_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY m.{$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(menu_id) as total FROM i_menuler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(menu_id) as total FROM i_menuler m" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT m.*, um.menu_baslik as ust_menu_adi 
            FROM i_menuler m 
            LEFT JOIN i_menuler um ON m.ust_id = um.menu_id 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $iconGoster = !empty($row['menu_icon']) ? '<span class="fs-16 me-1">'.$row['menu_icon'].'</span>' : '-';
            $ustKategori = !empty($row['ust_id']) ? '<span class="badge bg-light text-dark">'.htmlspecialchars($row['ust_menu_adi']).'</span>' : '<span class="badge bg-primary">Ana Menü</span>';

            $data[] = [
                'menu_id'          => $row['menu_id'], 
                'menu_durum'       => $row['menu_durum'],
                'sira'             => $row['sira'],
                'menu_icon'        => $iconGoster,
                'menu_baslik'      => htmlspecialchars($row['menu_baslik'] ?? ''),
                'menu_url'         => htmlspecialchars($row['menu_url'] ?? ''),
                'ust_id'           => $ustKategori,
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
        if(!empty($menu_baslik) && !empty($menu_url)){
            $array = [
                "ust_id"      => !empty($ust_id) ? intval($ust_id) : 0,
                "menu_tip"    => !empty($menu_tip) ? intval($menu_tip) : 0,
                "menu_baslik" => $menu_baslik,
                "menu_etiket" => !empty($menu_etiket) ? $menu_etiket : null,
                "menu_url"    => $menu_url,
                "menu_icon"   => !empty($menu_icon) ? $menu_icon : null,
                "menu_hedef"  => !empty($menu_hedef) ? $menu_hedef : '_self',
                "menu_durum"  => 1
            ];

            $add = $db->prepare("INSERT INTO i_menuler SET
                ust_id        = :ust_id,
                menu_tip      = :menu_tip,
                menu_baslik   = :menu_baslik,
                menu_etiket   = :menu_etiket,
                menu_url      = :menu_url,
                menu_icon     = :menu_icon,
                menu_hedef    = :menu_hedef,
                menu_durum    = :menu_durum");
            $kontrol = $add->execute($array);

            if($kontrol){
                alert("Başarılı","Menü öğesi başarıyla eklenmiştir.","success",true);
            }else{
                alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Menü Başlığı ve URL alanlarını boş bırakmayınız.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value) && !empty($menu_baslik) && !empty($menu_url)){
            $array = [
                "ust_id"      => !empty($ust_id) ? intval($ust_id) : 0,
                "menu_tip"    => !empty($menu_tip) ? intval($menu_tip) : 0,
                "menu_baslik" => $menu_baslik,
                "menu_etiket" => !empty($menu_etiket) ? $menu_etiket : null,
                "menu_url"    => $menu_url,
                "menu_icon"   => !empty($menu_icon) ? $menu_icon : null,
                "menu_hedef"  => !empty($menu_hedef) ? $menu_hedef : '_self',
                "menu_id"     => $value
            ];

            $update = $db->prepare("UPDATE i_menuler SET
                ust_id        = :ust_id,
                menu_tip      = :menu_tip,
                menu_baslik   = :menu_baslik,
                menu_etiket   = :menu_etiket,
                menu_url      = :menu_url,
                menu_icon     = :menu_icon,
                menu_hedef    = :menu_hedef
                WHERE menu_id = :menu_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Menü başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Uyarı","Lütfen Menü Başlığı ve URL alanlarını boş bırakmayınız.","warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $alt_guncelle = $db->prepare("UPDATE i_menuler SET ust_id = 0 WHERE ust_id = ?");
            $alt_guncelle->execute([$id]);

            $delete = $db->prepare("DELETE FROM i_menuler WHERE menu_id = ?");
            $delete->execute([$id]);

            if($delete->rowCount()){
                alert("Başarılı","Menü silinmiştir.","success",true);
            }else{
                alert("Hata","Menü silinememiştir.","error",true);
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT menu_durum FROM i_menuler WHERE menu_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["menu_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_menuler SET menu_durum = ? WHERE menu_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Menü yayına alınmıştır." : "Menü gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_menuler SET sira = ? WHERE menu_id = ?");
            
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

    if ($postType == "GetUstMenuler") {
        $menu_tip = isset($_POST['menu_tip']) ? intval($_POST['menu_tip']) : 0;
        
        $stmt = $db->prepare("SELECT menu_id, menu_baslik FROM i_menuler WHERE menu_tip = ? AND ust_id = 0 ORDER BY sira ASC");
        $stmt->execute([$menu_tip]);
        $ustMenuler = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($ustMenuler, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>