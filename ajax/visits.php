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
            $searchQuery = " WHERE (z.konu LIKE ? OR m.musteri_adi LIKE ? OR z.ilgili_kisi LIKE ?) ";
            $likeValue   = "%{$searchValue}%";
            $queryParams = [$likeValue, $likeValue, $likeValue];
        }

        $orderQuery = " ORDER BY z.id DESC ";
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $columnName  = $columns[$columnIndex]['data'] ?? 'id';
            $allowed     = ['konu', 'musteri_adi', 'ziyaret_tarihi', 'ziyaret_tipi', 'id'];
            if (in_array($columnName, $allowed)) {
                if($columnName == 'musteri_adi') $columnName = 'm.musteri_adi';
                else $columnName = 'z.' . $columnName;
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = ($length != -1) ? " LIMIT {$start}, {$length} " : "";

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_ziyaretler");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(z.id) as total FROM i_ziyaretler z LEFT JOIN i_musteriler m ON z.musteri_id = m.id" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("
            SELECT z.*, m.musteri_adi, m.unvan 
            FROM i_ziyaretler z 
            LEFT JOIN i_musteriler m ON z.musteri_id = m.id 
            " . $searchQuery . $orderQuery . $limitQuery
        );
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($results as $row) {
            $tip_etiket = ($row['ziyaret_tipi'] == 'biz_gittik') ? '<span class="badge bg-primary">Biz Ziyaret Ettik</span>' : '<span class="badge bg-info text-dark">Müşteri Bize Geldi</span>';

            $data[] = [
                'id'             => $row['id'], 
                'musteri_adi'    => htmlspecialchars($row['musteri_adi'] . (!empty($row['unvan']) ? ' - '.$row['unvan'] : '')),
                'ziyaret_tipi'   => $tip_etiket,
                'konu'           => htmlspecialchars($row['konu']),
                'ilgili_kisi'    => htmlspecialchars($row['ilgili_kisi'] ?? '-'),
                'ziyaret_tarihi' => tarihSaat($row['ziyaret_tarihi']),
                'id'             => $row['id']
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["draw" => $draw, "recordsTotal" => intval($recordsTotal), "recordsFiltered" => intval($recordsFiltered), "data" => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType == "Add") {
        if(!empty($musteri_id) && !empty($konu) && !empty($ziyaret_tarihi)){
            $array = [
                "musteri_id"         => intval($musteri_id),
                "ziyaret_tipi"       => $ziyaret_tipi ?? 'biz_gittik',
                "ziyaret_tarihi"     => $ziyaret_tarihi,
                "ilgili_kisi"        => !empty($ilgili_kisi) ? $ilgili_kisi : null,
                "konu"               => $konu,
                "aciklama"           => !empty($aciklama) ? $aciklama : null,
                "ekleyen_kullanici"  => $_SESSION['yonetici_adi'] ?? 'Admin'
            ];

            $add = $db->prepare("INSERT INTO i_ziyaretler SET
                musteri_id         = :musteri_id,
                ziyaret_tipi       = :ziyaret_tipi,
                ziyaret_tarihi     = :ziyaret_tarihi,
                ilgili_kisi        = :ilgili_kisi,
                konu               = :konu,
                aciklama           = :aciklama,
                ekleyen_kullanici  = :ekleyen_kullanici");
            
            if($add->execute($array)){
                alert("Başarılı", "Ziyaret kaydı başarıyla oluşturuldu.", "success", true);
            } else {
                alert("Hata", "Ziyaret kaydedilemedi.", "error");
            }
        }else{
            alert("Uyarı", "Lütfen zorunlu alanları doldurunuz.", "warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($musteri_id) && !empty($konu)){
            $array = [
                "musteri_id"     => intval($musteri_id),
                "ziyaret_tipi"   => $ziyaret_tipi ?? 'biz_gittik',
                "ziyaret_tarihi" => $ziyaret_tarihi,
                "ilgili_kisi"    => !empty($ilgili_kisi) ? $ilgili_kisi : null,
                "konu"           => $konu,
                "aciklama"       => !empty($aciklama) ? $aciklama : null,
                "id"             => intval($value)
            ];

            $update = $db->prepare("UPDATE i_ziyaretler SET
                musteri_id     = :musteri_id,
                ziyaret_tipi   = :ziyaret_tipi,
                ziyaret_tarihi = :ziyaret_tarihi,
                ilgili_kisi    = :ilgili_kisi,
                konu           = :konu,
                aciklama       = :aciklama
                WHERE id       = :id");
            
            if($update->execute($array)){
                alert("Başarılı", "Ziyaret kaydı güncellendi.", "success", true);
            } else {
                alert("Hata", "Güncelleme sırasında bir sorun oluştu.", "error");
            }
        }else{
            alert("Uyarı", "Zorunlu alanlar boş bırakılamaz.", "warning");
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $del = $db->prepare("DELETE FROM i_ziyaretler WHERE id = ?");
            $del->execute([$id]);
            if($del->rowCount()){
                alert("Başarılı", "Ziyaret kaydı silindi.", "success", true);
            } else {
                alert("Hata", "Kayıt silinemedi.", "error", true);
            }
        }
    }
}
?>