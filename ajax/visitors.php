<?php
header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "SELECT m.id AS musteri_id, m.musteri_adi, m.telefon, z.ziyaret_tarihi, (SELECT COUNT(*) FROM i_ziyaretler WHERE musteri_id = m.id) AS toplam_ziyaret, 'recognized' AS tip FROM i_ziyaretler z JOIN i_musteriler m ON z.musteri_id = m.id WHERE DATE(z.ziyaret_tarihi) = CURDATE() GROUP BY m.id ORDER BY z.ziyaret_tarihi DESC LIMIT 10";

    $stmt = $db->query($sql);
    $ziyaretciler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tempSql = "SELECT id AS musteri_id, ziyaretci_adi AS musteri_adi, fotograf, tespit_tarihi AS ziyaret_tarihi, 'temp' AS tip FROM i_canli_tespitler WHERE durum = 'bekliyor' AND DATE(tespit_tarihi) = CURDATE() ORDER BY id DESC LIMIT 15";

    $stmtTemp = $db->query($tempSql);
    $tempZiyaretciler = $stmtTemp->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success'   => true,
        'visitors'  => $ziyaretciler,
        'temp_visitors' => $tempZiyaretciler
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}