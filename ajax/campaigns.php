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
            $searchQuery = " WHERE (kampanya_adi LIKE ? OR kampanya_kodu LIKE ?) ";
            $likeValue   = "%{$searchValue}%";
            $queryParams = [$likeValue, $likeValue];
        }

        $orderQuery = " ORDER BY sira ASC, id DESC";
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $columnName  = $columns[$columnIndex]['data'] ?? 'id';
            $allowed     = ['kampanya_adi', 'kampanya_kodu', 'kampanya_turu', 'durum', 'id'];
            if (in_array($columnName, $allowed)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = ($length != -1) ? " LIMIT {$start}, {$length} " : "";

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_kampanyalar");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_kampanyalar" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("SELECT * FROM i_kampanyalar" . $searchQuery . $orderQuery . $limitQuery);
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($results as $row) {
            $durum_badge = ($row['durum'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Pasif</span>';
            
            $turler = [
                'yuzde_indirim' => 'Sepette % İndirim',
                'tutar_indirim' => 'Tutar İndirimi (₺)',
                'ucretsiz_kargo' => 'Ücretsiz Kargo'
            ];
            
            $tur_adi = $turler[$row['kampanya_turu']] ?? $row['kampanya_turu'];

            $data[] = [
                'id'            => $row['id'], // İşlem butonları için doğru id
                'sira'          => $row['sira'],
                'kampanya_adi'  => htmlspecialchars($row['kampanya_adi']),
                'kampanya_kodu' => !empty($row['kampanya_kodu']) ? '<span class="badge bg-light text-dark border">'.htmlspecialchars($row['kampanya_kodu']).'</span>' : '<span class="text-muted">-</span>',
                'kampanya_turu' => $tur_adi,
                'deger'         => ($row['kampanya_turu'] == 'ucretsiz_kargo') ? '-' : number_format($row['indirim_orani'], 2, ',', '.') . ($row['kampanya_turu'] == 'yuzde_indirim' ? ' %' : ' ₺'),
                'durum_gorunum' => $durum_badge, // Tabloda rozet görünmesi için
                'durum'         => intval($row['durum']) // Durum butonunun düzgün çalışması için ham sayısal değer (0 veya 1)
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["draw" => $draw, "recordsTotal" => intval($recordsTotal), "recordsFiltered" => intval($recordsFiltered), "data" => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType == "Add") {
        if(!empty($kampanya_adi) && !empty($kampanya_turu)){
            $array = [
                "kampanya_adi"     => $kampanya_adi,
                "kampanya_kodu"    => !empty($kampanya_kodu) ? strtoupper(trim($kampanya_kodu)) : null,
                "kampanya_turu"    => $kampanya_turu,
                "indirim_orani"    => !empty($indirim_orani) ? floatval($indirim_orani) : 0.00,
                "min_sepet_tutar"  => !empty($min_sepet_tutar) ? floatval($min_sepet_tutar) : 0.00,
                "baslangic_tarihi" => !empty($baslangic_tarihi) ? $baslangic_tarihi : null,
                "bitis_tarihi"     => !empty($bitis_tarihi) ? $bitis_tarihi : null,
                "durum"            => isset($durum) ? 1 : 0
            ];

            $add = $db->prepare("INSERT INTO i_kampanyalar SET
                kampanya_adi     = :kampanya_adi,
                kampanya_kodu    = :kampanya_kodu,
                kampanya_turu    = :kampanya_turu,
                indirim_orani    = :indirim_orani,
                min_sepet_tutar  = :min_sepet_tutar,
                baslangic_tarihi = :baslangic_tarihi,
                bitis_tarihi     = :bitis_tarihi,
                durum            = :durum");
            
            if($add->execute($array)){
                alert("Başarılı", "Kampanya başarıyla oluşturuldu.", "success", true);
            } else {
                alert("Hata", "Kampanya kodu kullanımda olabilir.", "error");
            }
        }else{
            alert("Uyarı", "Lütfen zorunlu alanları doldurunuz.", "warning");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value) && !empty($kampanya_adi)){
            $array = [
                "kampanya_adi"     => $kampanya_adi,
                "kampanya_kodu"    => !empty($kampanya_kodu) ? strtoupper(trim($kampanya_kodu)) : null,
                "kampanya_turu"    => $kampanya_turu,
                "indirim_orani"    => !empty($indirim_orani) ? floatval($indirim_orani) : 0.00,
                "min_sepet_tutar"  => !empty($min_sepet_tutar) ? floatval($min_sepet_tutar) : 0.00,
                "baslangic_tarihi" => !empty($baslangic_tarihi) ? $baslangic_tarihi : null,
                "bitis_tarihi"     => !empty($bitis_tarihi) ? $bitis_tarihi : null,
                "durum"            => isset($durum) ? 1 : 0,
                "id"               => intval($value)
            ];

            $update = $db->prepare("UPDATE i_kampanyalar SET
                kampanya_adi     = :kampanya_adi,
                kampanya_kodu    = :kampanya_kodu,
                kampanya_turu    = :kampanya_turu,
                indirim_orani    = :indirim_orani,
                min_sepet_tutar  = :min_sepet_tutar,
                baslangic_tarihi = :baslangic_tarihi,
                bitis_tarihi     = :bitis_tarihi,
                durum            = :durum
                WHERE id         = :id");
            
            if($update->execute($array)){
                alert("Başarılı", "Kampanya başarıyla güncellendi.", "success", true);
            } else {
                alert("Hata", "Güncelleme sırasında bir sorun oluştu.", "error");
            }
        }else{
            alert("Uyarı", "Zorunlu alanlar boş bırakılamaz.", "warning");
        }
    }

    if ($postType == "Durum") {
        if(!empty($id)){
            $kontrol = $db->prepare("SELECT durum FROM i_kampanyalar WHERE id = ?");
            $kontrol->execute([$id]);
            if($kontrol->rowCount()){
                $cek = $kontrol->fetch(PDO::FETCH_ASSOC);
                $yeni = ($cek["durum"] == 1) ? 0 : 1;
                $db->prepare("UPDATE i_kampanyalar SET durum = ? WHERE id = ?")->execute([$yeni, $id]);
                alert("Başarılı", "Kampanya durumu güncellendi.", "success", true);
            }
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $del = $db->prepare("DELETE FROM i_kampanyalar WHERE id = ?");
            $del->execute([$id]);
            if($del->rowCount()){
                alert("Başarılı", "Kampanya silindi.", "success", true);
            } else {
                alert("Hata", "Kampanya silinemedi.", "error", true);
            }
        }
    }

    if ($postType == "Siralama") {
        $siralamaDizisi = $siralama ?? ($_POST['siralama'] ?? []);

        if (!empty($siralamaDizisi) && is_array($siralamaDizisi)) {
            $stmt = $db->prepare("UPDATE i_kampanyalar SET sira = ? WHERE id = ?");
            
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