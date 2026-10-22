<?php

ob_start();

session_start();


define('ENVIRONMENT', 'development'); 

if (ENVIRONMENT === 'development') {
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
} else {
    ini_set("display_errors", 0);
    ini_set("display_startup_errors", 0);
    error_reporting(0);
}

date_default_timezone_set('Europe/Istanbul');

$dbHost     = "localhost";
$dbName     = "x";
$dbUser     = "x";
$dbPass     = "x";

try {
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $db = new PDO($dsn, $dbUser, $dbPass, $options);
    
} catch (PDOException $e) {
    if (ENVIRONMENT === 'development') {
        die("<strong>Veritabanı Bağlantı Hatası:</strong> " . $e->getMessage());
    } else {
        error_log($e->getMessage()); // Hatayı sunucu error.log dosyasına yaz
        die("Sistemde geçici bir sorun yaşanıyor. Lütfen daha sonra tekrar deneyin.");
    }
}
$ayar = $db->query("SELECT * FROM i_ayar LIMIT 1")->fetch();


if (!$ayar) {
    die("Sistem ayarları veritabanından okunamadı. Lütfen 'i_ayarlar' tablosunu kontrol ediniz.");
}

$seo_cek    = json_decode($ayar["seo_ayarlari"],true);
$tema_cek   = json_decode($ayar["tema_ayarlari"],true);

$front_pages = [
    "giris", 
    "sifremi-unuttum", 
    "sifre-sifirla"
];

defined("URL") || define("URL", rtrim($ayar["site_url"], '/') . '/');
define("ADMIN_URL",URL);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}