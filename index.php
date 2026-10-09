<?php 
require_once 'system/fonksiyon.php';

$act_kontrol = $_GET["act"] ?? "index";
$par = array_filter(explode("/", $act_kontrol));
$pages = $par[0] ?? 'index';

$bakim_sorgu = $db->query("SELECT bakim_modu FROM i_ayar LIMIT 1");
if($bakim_sorgu && $bakim_sorgu->rowCount() > 0) {
    $bakim_durum = $bakim_sorgu->fetchColumn();

    if ($bakim_durum == 1) {
        $muaf_sayfalar = ['giris', 'request', 'cikis'];
        $yonetici_girisli = isset($_SESSION['uye_id']) && ($_SESSION['uye_rutbe'] ?? 1) > 0;
        
        $muafiyette_mi = in_array($pages, $muaf_sayfalar);

        if (!$yonetici_girisli && !$muafiyette_mi) {
            echo '<div style="text-align:center; padding:100px; height:100vh; font-family:sans-serif; background:#f8f9fa; color:#333;">
                    <h1 style="font-size:40px; color:#dc3545; margin-bottom:10px;">Sitemiz Bakımdadır</h1>
                    <p style="font-size:18px; color:#6c757d;">En kısa sürede tekrar yayında olacağız. Lütfen daha sonra tekrar ziyaret ediniz.</p>
                  </div>';
            exit;
        }
    }
}

$giris_cek = giris_varmi();

$sepetim = sepetim();

if($pages == "request"){
    require 'system/ajax_post.php';
    die();
}

giris_yonlendir();

if (isset($_SESSION["is_locked"]) && $_SESSION["is_locked"] === true) {
    if ($pages !== 'lock') {
        header("Location: " . URL . "lock");
        exit;
    }
}

if(!in_array($pages, $front_pages)){
    require_once 'parts/header.php';
}

if(isset($pages)){
    if(file_exists("pages/" . $pages . ".php")){
        require_once "pages/" . $pages . ".php";
    }else{
        //require_once 'pages/404.php';
    }
}else{
    //require_once 'pages/404.php';
}

if(!in_array($pages, $front_pages)){
    require_once 'parts/footer.php';
}
?>