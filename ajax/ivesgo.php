<?php 

if (isset($_POST['postType']) || isset($_GET['postType'])) {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'system/ayar.php';

    $postType = $_POST['postType'] ?? $_GET['postType'];

    $postVerileri = [
        'api_token'   => $ayar['api_token'] ?? '',
        'token'       => 'IVS++159',
        'site_domain' => $_SERVER['HTTP_HOST'] ?? '',
        'postType'    => $postType
    ];

    if ($postType === 'add_mail_account') {
        $postVerileri['email_prefix'] = trim($_POST['email_prefix'] ?? '');
        $postVerileri['password'] = trim($_POST['password'] ?? '');
        $postVerileri['quota'] = 250;
    } elseif ($postType === 'update_mail_password') {
        $postVerileri['email'] = trim($_POST['email'] ?? '');
        $postVerileri['password'] = trim($_POST['password'] ?? '');
    } elseif ($postType === 'Sil') {
        $postVerileri['email'] = trim($_POST['id'] ?? '');
    }else{

    }

    $postData = http_build_query($postVerileri, '', '&');
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.ivesgo.com/panelApi.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo json_encode([
            'durum' => 'hata',
            'mesaj' => 'Sunucu bağlantı hatası: ' . $err
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo $response;
    }
    exit;
}
?>