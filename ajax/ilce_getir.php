<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['il_id'])){
    exit('<option value="">Geçersiz İstek</option>');
}

$il_id = intval($_POST['il_id']);

$sorgu = $db->prepare("SELECT * FROM ilceler WHERE ilce_il_id = ? ORDER BY ilce_adi ASC");
$sorgu->execute([$il_id]);


echo '<option value="">İlçe Seçiniz</option>';


if($sorgu->rowCount() > 0) {
    foreach($sorgu as $ilce){
        echo '<option value="'.$ilce['ilce_id'].'">'.$ilce['ilce_adi'].'</option>';
    }
} else {
    echo '<option value="">Bu ile ait ilçe bulunamadı</option>';
}
?>