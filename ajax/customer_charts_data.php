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
        echo json_encode(['success' => false, 'message' => 'Müşteri ID eksik.']);
        exit;
    }

    $categories = [];
    $ziyaretSayisi = [];
    $alisverisTutari = [];

    $turkceAylar = ['01' => 'Oca', '02' => 'Şub', '03' => 'Mar', '04' => 'Nis', '05' => 'May', '06' => 'Haz', '07' => 'Tem', '08' => 'Ağu', '09' => 'Eyl', '10' => 'Eki', '11' => 'Kas', '12' => 'Ara'];

    for ($i = 11; $i >= 0; $i--) {
        $yilAy = date('Y-m', strtotime("-$i months"));
        $yil = date('Y', strtotime("-$i months"));
        $ay = date('m', strtotime("-$i months"));
        
        $categories[] = ($turkceAylar[$ay] ?? $ay) . ' ' . substr($yil, 2);

        // Ziyaret Sayısı
        $stmtZiyaret = $db->prepare("SELECT COUNT(*) FROM i_ziyaretler WHERE musteri_id = ? AND DATE_FORMAT(ziyaret_tarihi, '%Y-%m') = ?");
        $stmtZiyaret->execute([$musteriId, $yilAy]);
        $ziyaretSayisi[] = (int)$stmtZiyaret->fetchColumn();

        $stmtSiparis = $db->prepare("SELECT COALESCE(SUM(genel_toplam), 0) FROM i_siparisler WHERE musteri_id = ? AND DATE_FORMAT(eklenme_tarihi, '%Y-%m') = ?");
        $stmtSiparis->execute([$musteriId, $yilAy]);
        $alisverisTutari[] = (float)$stmtSiparis->fetchColumn();
    }

    $stmtSegment = $db->prepare("SELECT odeme_yontemi, COUNT(*) as adet, SUM(genel_toplam) as toplam FROM i_siparisler WHERE musteri_id = ? GROUP BY odeme_yontemi");
    $stmtSegment->execute([$musteriId]);
    $segmentKayitlari = $stmtSegment->fetchAll(PDO::FETCH_ASSOC);

    $segmentLabels = [];
    $segmentSeries = [];

    if (count($segmentKayitlari) > 0) {
        foreach ($segmentKayitlari as $seg) {
            $segmentLabels[] = !empty($seg['odeme_yontemi']) ? $seg['odeme_yontemi'] : 'Diğer / Belirtilmemiş';
            $segmentSeries[] = (float)$seg['toplam'];
        }
    } else {
        $segmentLabels = ['Kredi Kartı', 'Nakit', 'Havale / EFT'];
        $segmentSeries = [0, 0, 0];
    }

    echo json_encode([
        'success' => true,
        'trend' => [
            'categories' => $categories,
            'visits' => $ziyaretSayisi,
            'amounts' => $alisverisTutari
        ],
        'segment' => [
            'labels' => $segmentLabels,
            'series' => $segmentSeries
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Veri tabanı hatası: ' . $e->getMessage()
    ]);
}