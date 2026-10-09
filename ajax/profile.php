<?php
header('Content-Type: application/json; charset=utf-8');

try {
    if (!isset($db)) {
        throw new Exception("Veritabanı bağlantısı bulunamadı.");
    }

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $musteriId = $input['musteri_id'] ?? null;

    if (empty($musteriId)) {
        echo json_encode(['success' => false, 'message' => 'Geçersiz müşteri IDsi.']);
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM i_musteriler WHERE id = ?");
    $stmt->execute([$musteriId]);
    $musteri = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$musteri) {
        echo json_encode(['success' => false, 'message' => 'Müşteri bulunamadı.']);
        exit;
    }

    if (!empty($musteri['notlar'])) {
        $decodedNotlar = json_decode($musteri['notlar'], true);
        $musteri['notlar'] = is_array($decodedNotlar) ? $decodedNotlar : [];
    } else {
        $musteri['notlar'] = [];
    }

    $stmtZiyaret = $db->prepare("SELECT COUNT(*) FROM i_ziyaretler WHERE musteri_id = ?");
    $stmtZiyaret->execute([$musteriId]);
    $toplamZiyaret = $stmtZiyaret->fetchColumn() ?: 0;

    $stmtSiparis = $db->prepare("SELECT siparis_kodu, genel_toplam, urunler, eklenme_tarihi FROM i_siparisler WHERE musteri_id = ? ORDER BY id DESC LIMIT 5");
    $stmtSiparis->execute([$musteriId]);
    $siparisler = $stmtSiparis->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success'       => true,
        'customer'      => $musteri,
        'total_visits'  => $toplamZiyaret,
        'orders'        => $siparisler
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Hata: ' . $e->getMessage()]);
}