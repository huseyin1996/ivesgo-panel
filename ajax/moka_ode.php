<?php
if($_POST){
    extract($_POST);

    $siparis_id = isset($_SESSION["siparis_id"]) ? $_SESSION["siparis_id"] : '';
    
    $siparis_varmi = $db->prepare("SELECT id, fiyat, takip_no FROM i_siparisler WHERE takip_no = ?");
    $siparis_varmi->execute([$siparis_id]);
    
    if(!$siparis_varmi->rowCount()){
        header('Content-Type: application/json');
        echo json_encode([
            'status'  => 'error',
            'title'   => 'Uyarı',
            'message' => 'Sipariş oturumunuz sonlanmış. Lütfen sayfayı yenileyin.',
            'reload'  => true
        ]);
        exit;
    }
    
    $siparis_cek = $siparis_varmi->fetch(PDO::FETCH_ASSOC);

    $sanalPos = new SanalPos($db);

    $ekVeriler = [
        'siparis_id' => $siparis_id,
        'pan'        => $pan ?? '',
        'name'       => $name ?? '',
        'month'      => $month ?? '',
        'year'       => $year ?? '',
        'cv2'        => $cv2 ?? '',
        'taksit'     => 1
    ];

    $odemeSonuc = $sanalPos->odemeBaslat($siparis_cek, [], [], $ekVeriler);

    header('Content-Type: application/json');

    if ($odemeSonuc['success'] && isset($odemeSonuc['redirect_url'])) {
        echo json_encode([
            'status' => 'success',
            'url'    => $odemeSonuc['redirect_url']
        ]);
        exit;
    } else {
        echo json_encode([
            'status'  => 'error',
            'title'   => 'Uyarı',
            'message' => 'Hata! ' . ($odemeSonuc['message'] ?? 'Bilinmeyen hata'),
            'reload'  => false
        ]);
        exit;
    }
}
?>