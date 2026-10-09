<?php
    if (!empty($_SESSION['uye_eposta'])) {
        if (!isset($_SESSION["is_locked"])) {
            $_SESSION["is_locked"] = true;
        }
    }else{
        unset($_SESSION['is_locked']);
        header("Location:" . ADMIN_URL . "giris");
    }
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<head>
    <?php $url = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>
    <base href="<?=URL?>">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$seo_cek['title']?></title>
    <meta name="Description" content="<?=$seo_cek['title']?>">
    <meta name="Author" content="İvesgo Web Tasarım | B2B | CRM Hizmetleri">
    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <script src="assets/js/authentication-main.js"></script>
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="assets/libs/sweetalert2/sweetalert2.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
</head>

<body class="authentication-background">
    <div class="authentication-basic-background">
        <img src="assets/images/media/landing/background/5.jpg" alt="">
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                <div class="card custom-card border-0 my-4">
                    <div class="card-body p-5">
                        <div class="mb-4 pb-2 d-flex align-items-center justify-content-center"> 
                            <a href="<?=URL?>"> 
                                <?php if (resimVarmi('logo/', $ayar['koyu_logo'])): ?>
                                    <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-logo">
                                    <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-dark d-none">
                                <?php endif; ?> 
                            </a> 
                        </div>
                        <div class="text-center">
                            <span class="avatar avatar-xxl p-1 bg-light avatar-rounded">
                                <img src="assets/images/faces/12.jpg" alt="">
                            </span>
                            <p class="fs-18 mt-2 mb-0 fw-semibold">Hoşgeldin <?=$giris_cek['uye_ad_soyad']?></p>
                            <p class="mb-3 text-muted fw-normal">Uzun süre işlem yamadığınız için tekrar giriş yapmaknız gerekmektedir.</p>
                        </div>
                        <form class="postForm" action="request/lock" method="post">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                            <div class="row gy-3">
                                <div class="col-xl-12 mb-2">
                                    <label for="password" class="form-label text-default">Şifreniz</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi Giriniz">
                                        <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-primary py-2" aria-label="Giriş Yap">Giriş Yap</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/show-password.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>var _url = '<?=URL?>';</script>
    <script src="assets/js/script.js"></script>
</body>
</html>