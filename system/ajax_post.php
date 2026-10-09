<?php
if (!isset($_SESSION['uye_id']) && !in_array($par[1] ?? '', ['login', 'sifre-sifirla'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['type' => 'error', 'message' => 'Bu işlem için yetkiniz yok veya oturumunuz sonlandırıldı.']);
        exit;
    } else {
        header("Location: " . URL . "giris");
        exit;
    }
}


$bakim_sorgu = $db->query("SELECT bakim_modu FROM i_ayar LIMIT 1");
if($bakim_sorgu && $bakim_sorgu->rowCount() > 0) {
    if ($bakim_sorgu->fetchColumn() == 1) {
        $yonetici_mi = isset($_SESSION['uye_rutbe']) && $_SESSION['uye_rutbe'] > 0;
        $muaf_requestler = ['login'];
        
        if (!$yonetici_mi && !in_array($par[1] ?? '', $muaf_requestler)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['type' => 'error', 'message' => 'Sistem bakımdadır. İşlem gerçekleştirilemez.']);
            exit;
        }
    }
}

if(isset($par[1])){
    $dosya_adi = $par[1];
    
    
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $dosya_adi)) {
        http_response_code(400);
        echo json_encode(['type' => 'error', 'message' => 'Geçersiz dosya adı.']);
        exit;
    }
    
    if (strpos($dosya_adi, '..') !== false || strpos($dosya_adi, '/') !== false) {
        http_response_code(400);
        echo json_encode(['type' => 'error', 'message' => 'Geçersiz dosya adı.']);
        exit;
    }
    
    $hedef_yol = "ajax/" . $dosya_adi . ".php";
    
    if(!file_exists($hedef_yol) || !is_file($hedef_yol)) {
        http_response_code(404);
        echo json_encode(['type' => 'error', 'message' => 'İşlem bulunamadı.']);
        exit;
    }
    
    require_once $hedef_yol;
    
} else {
    http_response_code(400);
    echo json_encode(['type' => 'error', 'message' => 'Geçersiz istek.']);
    exit;
}
?>