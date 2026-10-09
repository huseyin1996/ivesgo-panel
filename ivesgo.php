<?php
require_once 'system/ayar.php';

$postVerileri = [
    'api_token' => $ayar['api_token'],
    'token' => 'IVS++159',
    'site_domain' => $_SERVER['HTTP_HOST'] ?? ''
];

$postData = http_build_query($postVerileri,'','&');

$ch = curl_init();

curl_setopt_array($ch,[
    CURLOPT_URL=>'https://www.ivesgo.com/panelApi.php',
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_POST=>true,
    CURLOPT_POSTFIELDS=>$postData,
    CURLOPT_HTTPHEADER=>[
        'Content-Type: application/x-www-form-urlencoded',
        'Content-Length: '.strlen($postData)
    ],
    CURLOPT_SSL_VERIFYPEER=>true,
    CURLOPT_SSL_VERIFYHOST=>2,
    CURLOPT_FOLLOWLOCATION=>false,
    CURLOPT_TIMEOUT=>20,
    CURLOPT_CONNECTTIMEOUT=>10
]);

$response = curl_exec($ch);

if($response === false){
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
curl_close($ch);

if($httpCode !== 200){
    exit;
}

$veriler = json_decode($response,true);



$websiteler = $veriler['websiteler'] ?? [];

$hizmetler = [];

foreach($websiteler as $website){
    $hizmetler[] = [
        'paket_adi' => $website['paket_detay']['paket_adi'] ?? '',
        'hizmetuzat' => $website['hizmetuzat'] ?? ''
    ];
}

echo json_encode([
    'durum'         => 'basarili',
    'hizmetler'     => $hizmetler
], JSON_UNESCAPED_UNICODE);
?>
