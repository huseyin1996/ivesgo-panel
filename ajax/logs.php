<?php
if(isset($_POST)){
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
            exit;
        }
    }

    $postType = $_POST['postType'] ?? '';

    if ($postType == "List") {
        $draw         = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $start        = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length       = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $searchValue  = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

        $columns = $_POST['columns'] ?? [];
        $searchQuery = "";
        $queryParams = [];

        // Arama kutusu doldurulduğunda log açıklamalarında veya işlem türünde arama yapması
        if (!empty($searchValue)) {
            $searchQuery = " WHERE (l.aciklama LIKE ? OR l.islem_turu LIKE ? OR l.modul LIKE ? OR l.ip_adresi LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%", "%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY l.id DESC "; 
        
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            
            $columnName = $columns[$columnIndex]['data'] ?? 'id';
            $allowedColumns = ['id', 'islem_turu', 'modul', 'aciklama', 'ip_adresi', 'tarih'];
            
            if (in_array($columnName, $allowedColumns)) {
                $orderQuery = " ORDER BY l.{$columnName} {$sortDir} ";
            }
        }

        $limitQuery = "";
        if ($length != -1) {
            $limitQuery = " LIMIT {$start}, {$length} ";
        }

        // Toplam kayıt sayısı
        $totalQuery = $db->query("SELECT COUNT(id) as total FROM system_logs");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        // Filtrelenmiş kayıt sayısı
        $filteredQuery = $db->prepare("SELECT COUNT(l.id) as total FROM system_logs l LEFT JOIN i_uyeler u ON l.personel_id = u.uye_id" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        // Verileri i_uyeler tablosu ile JOIN yaparak çekiyoruz (Personel / Üye Adı Soyadı için)
        $dataQuery = $db->prepare("
            SELECT l.*, u.uye_ad_soyad
            FROM system_logs l 
            LEFT JOIN i_uyeler u ON l.personel_id = u.uye_id 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        $siraNo = $start + 1;

        foreach ($results as $row) {
            // Personel Adı Soyadı (Eğer sistem dışı veya ID 0 ise Sistem / Misafir yazar)
            $uyeAdiSoyadi = 'Sistem / Otomatik';
            if (!empty($row['uye_ad_soyad']) ) {
                $uyeAdiSoyadi = htmlspecialchars(trim(($row['uye_ad_soyad'] ?? '')));
            } elseif (!empty($row['personel_id']) && $row['personel_id'] > 0) {
                $uyeAdiSoyadi = 'Personel ID: ' . $row['personel_id'];
            }

            // İşlem türüne göre rozet (badge) tasarımı
            $islemBadge = '<span class="badge bg-secondary">' . htmlspecialchars($row['islem_turu']) . '</span>';
            $tuer = strtoupper($row['islem_turu']);
            if ($tuer === 'DELETE') {
                $islemBadge = '<span class="badge bg-danger">SİLME (DELETE)</span>';
            } elseif ($tuer === 'UPDATE') {
                $islemBadge = '<span class="badge bg-warning text-dark">GÜNCELLEME</span>';
            } elseif ($tuer === 'INSERT') {
                $islemBadge = '<span class="badge bg-success">EKLEME</span>';
            } elseif ($tuer === 'WARNING') {
                $islemBadge = '<span class="badge bg-info text-dark">UYARI / GÜVENLİK</span>';
            }

            $data[] = [
                'sira'       => $siraNo++,
                'uye'        => '<div class="fw-semibold">' . $uyeAdiSoyadi . '</div><span class="fs-12 text-muted">Modül: ' . htmlspecialchars($row['modul'] ?? 'Genel') . '</span>',
                'islem_turu' => $islemBadge,
                'aciklama'   => htmlspecialchars($row['aciklama']),
                'ip'         => '<span class="font-monospace text-muted">' . htmlspecialchars($row['ip_adresi']) . '</span>',
                'tarih'      => function_exists('tarihSaat') ? tarihSaat($row['tarih']) : $row['tarih']
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
}