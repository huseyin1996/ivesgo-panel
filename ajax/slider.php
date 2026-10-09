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
            $searchQuery = " WHERE (fotograf_baslik LIKE ? OR buton_yazi LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY sira ASC, fotograf_id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'sira';
            $allowedColumns = ['fotograf_baslik', 'buton_yazi', 'sira', 'fotograf_durum', 'fotograf_id'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        $totalQuery = $db->query("SELECT COUNT(fotograf_id) as total FROM i_fotograflar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(fotograf_id) as total FROM i_fotograflar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT * FROM i_fotograflar 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $resim_goster = '<span class="text-muted" style="font-size:12px;">Görsel Yok</span>';
            if (!empty($row['fotograf_resim'])) {
                $resim_yolu = 'assets/images/slider/thumb/' . htmlspecialchars($row['fotograf_resim']);
                $resim_goster = '<img src="' . $resim_yolu . '" alt="Slider Görseli" width="80" height="40" style="object-fit:cover;" class="rounded shadow-sm">';
            }

            $data[] = [
                'fotograf_id'      => $row['fotograf_id'], 
                'fotograf_durum'   => $row['fotograf_durum'],
                'sira'             => $row['sira'],
                'fotograf_resim'   => $resim_goster,
                'fotograf_baslik'  => htmlspecialchars($row['fotograf_baslik'] ?? 'Başlıksız Slider'),
                'buton_yazi'       => htmlspecialchars($row['buton_yazi'] ?? '-'),
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
        if(isset($_FILES['fotograf_resim']) && $_FILES['fotograf_resim']['error'] == 0){
            $resim_adi = resim_yukle($_FILES['fotograf_resim'], 'assets/images/slider/', 'slide_');

            if($resim_adi){
                $array = [
                    "fotograf_baslik"   => !empty($fotograf_baslik) ? $fotograf_baslik : null,
                    "fotograf_aciklama" => !empty($fotograf_aciklama) ? $fotograf_aciklama : null,
                    "fotograf_resim"    => $resim_adi,
                    "buton_yazi"        => !empty($buton_yazi) ? $buton_yazi : null,
                    "buton_url"         => !empty($buton_url) ? $buton_url : null,
                    "buton_hedef"       => !empty($buton_hedef) ? $buton_hedef : '_self',
                    "fotograf_durum"    => 1
                ];

                $add = $db->prepare("INSERT INTO i_fotograflar SET
                    fotograf_baslik     = :fotograf_baslik,
                    fotograf_aciklama   = :fotograf_aciklama,
                    fotograf_resim      = :fotograf_resim,
                    buton_yazi          = :buton_yazi,
                    buton_url           = :buton_url,
                    buton_hedef         = :buton_hedef,
                    fotograf_durum      = :fotograf_durum");
                $kontrol = $add->execute($array);

                if($kontrol){
                    alert("Başarılı","Slider görseli başarıyla eklenmiştir.","success",true);
                }else{
                    alert("Hata","Veritabanına kaydedilirken bir sorun oluştu.","error");
                }
            } else {
                alert("Hata","Görsel yüklenemedi, lütfen formatı kontrol edin.","error");
            }
        }else{
            alert("Uyarı","Lütfen slider için bir arkaplan/manşet görseli seçin.","warning");
        }
    }
    
    if ($postType == "Edit") {
        if(!empty($value)){
            $array = [
                "fotograf_baslik"   => !empty($fotograf_baslik) ? $fotograf_baslik : null,
                "fotograf_aciklama" => !empty($fotograf_aciklama) ? $fotograf_aciklama : null,
                "buton_yazi"        => !empty($buton_yazi) ? $buton_yazi : null,
                "buton_url"         => !empty($buton_url) ? $buton_url : null,
                "buton_hedef"       => !empty($buton_hedef) ? $buton_hedef : '_self',
                "fotograf_id"       => $value
            ];

            $resim_sql = "";

            if (isset($resmi_sil) && $resmi_sil == 1) {
                $eski_resim_sorgu = $db->prepare("SELECT fotograf_resim FROM i_fotograflar WHERE fotograf_id = ?");
                $eski_resim_sorgu->execute([$value]);
                $eski = $eski_resim_sorgu->fetch();
                
                if(!empty($eski['fotograf_resim'])){
                    resim_sil($eski['fotograf_resim'], 'assets/images/slider/');
                }
                $resim_sql = "fotograf_resim = NULL,";
            } 
            elseif (isset($_FILES['fotograf_resim']) && $_FILES['fotograf_resim']['error'] == 0) {
                $resim_adi = resim_yukle($_FILES['fotograf_resim'], 'assets/images/slider/', 'slide_');
                
                if($resim_adi){
                    $resim_sql = "fotograf_resim = :fotograf_resim,";
                    $array["fotograf_resim"] = $resim_adi;
                    
                    $eski_resim_sorgu = $db->prepare("SELECT fotograf_resim FROM i_fotograflar WHERE fotograf_id = ?");
                    $eski_resim_sorgu->execute([$value]);
                    $eski = $eski_resim_sorgu->fetch();
                    
                    if(!empty($eski['fotograf_resim'])){
                        resim_sil($eski['fotograf_resim'], 'assets/images/slider/');
                    }
                }
            }

            $update = $db->prepare("UPDATE i_fotograflar SET
                fotograf_baslik     = :fotograf_baslik,
                fotograf_aciklama   = :fotograf_aciklama,
                {$resim_sql}
                buton_yazi          = :buton_yazi,
                buton_url           = :buton_url,
                buton_hedef         = :buton_hedef
                WHERE fotograf_id   = :fotograf_id");
            $kontrol = $update->execute($array);

            if($kontrol){
                alert("Başarılı","Slider başarıyla güncellenmiştir.","success",true);
            }else{
                alert("Hata","Güncelleme sırasında bir sorun oluştu.","error");
            }
        }else{
            alert("Hata","Geçersiz kayıt ID'si.","error");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT fotograf_id FROM i_fotograflar WHERE fotograf_id = ?");
            $kontrol->execute([$id]);

            if($kontrol->rowCount()){
                $eski_resim_sorgu = $db->prepare("SELECT fotograf_resim FROM i_fotograflar WHERE fotograf_id = ?");
                $eski_resim_sorgu->execute([$id]);
                $eski = $eski_resim_sorgu->fetch();

                if(!empty($eski['fotograf_resim'])){
                    resim_sil($eski['fotograf_resim'], 'assets/images/slider/');
                }

                $delete = $db->prepare("DELETE FROM i_fotograflar WHERE fotograf_id = ?");
                $delete->execute([$id]);

                if($delete->rowCount()){
                    alert("Başarılı","Slider ve görseli silinmiştir.","success",true);
                }else{
                    alert("Hata","Slider silinememiştir.","error",true);
                }
            }
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT fotograf_durum FROM i_fotograflar WHERE fotograf_id = ?");
            $kontrol->execute([$id]);
            
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni_durum = ($cek["fotograf_durum"] == 1) ? 0 : 1;
                
                $update = $db->prepare("UPDATE i_fotograflar SET fotograf_durum = ? WHERE fotograf_id = ?");
                $update->execute([$yeni_durum, $id]);
                
                if($update->rowCount()){
                    $mesaj = ($yeni_durum == 1) ? "Slider yayına alınmıştır." : "Slider gizlenmiştir.";
                    alert("Başarılı", $mesaj, "success", true);
                }
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_fotograflar SET sira = ? WHERE fotograf_id = ?");
            
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
                alert("Başarılı", "Slider sıralaması güncellendi.", "success", true);
            } else {
                alert("Hata", "Sıralama güncellenirken bir sorun oluştu.", "error");
            }
        }
    }
}
?>