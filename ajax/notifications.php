<?php


error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

// Oturum ve DB kontrolü (Kendi proje yapılandırmanıza göre dahil edin)
// include '../config.php'; 

$rawInput = file_get_contents('php://input');$jsonInput = json_decode($rawInput, true);$postType = $jsonInput['postType'] ?? $_POST['postType'] ?? '';

$aktifPersonelId =$_SESSION['uye_id'] ?? 0;

try {
    if ($postType === 'getBildirimler') {
        $stmt =$db->prepare(" SELECT * FROM i_bildirimler WHERE (personel_id = ? OR personel_id IS NULL) ORDER BY id DESC LIMIT 10 ");
        $stmt->execute([$aktifPersonelId]);
        $bildirimler =$stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtCount =$db->prepare(" SELECT COUNT(*) FROM i_bildirimler WHERE (personel_id = ? OR personel_id IS NULL) AND okundu = 0 ");
        $stmtCount->execute([$aktifPersonelId]);
        $okunmamisSayisi = (int)$stmtCount->fetchColumn();

        echo json_encode([
            'success' => true,
            'okunmamis' => $okunmamisSayisi,
            'bildirimler' => $bildirimler
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType === 'okunduIsaretle') {$bildirimId = (int) ($jsonInput['id'] ?? $_POST['id'] ?? 0);
        if ($bildirimId > 0) {
            $stmt =$db->prepare("UPDATE i_bildirimler SET okundu = 1 WHERE id = ?");
            $stmt->execute([$bildirimId]);
        } else {
            // ID gönderilmediyse tümünü okundu yap
            $stmt =$db->prepare("UPDATE i_bildirimler SET okundu = 1 WHERE personel_id = ? OR personel_id IS NULL");
            $stmt->execute([$aktifPersonelId]);
        }

        echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Geçersiz işlem.'], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'Sunucu hatası.'], JSON_UNESCAPED_UNICODE);
}