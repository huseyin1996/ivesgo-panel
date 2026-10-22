<?php
if (isset($_SESSION['uye_id'])) {
    header("Location: " . URL . "index");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<head>
    <base href="<?=URL?>">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Şifremi Unuttum | <?=$ayar['site_baslik'] ?? 'Klinik Portal'?></title>
    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <script src="assets/js/authentication-main.js"></script>
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="card custom-card border-0 my-4 shadow-sm">
                    <div class="card-body p-5">
                        <div class="mb-4 pb-2 d-flex align-items-center justify-content-center"> 
                            <a href="<?=URL?>"> 
                                <?php if (function_exists('resimVarmi') && resimVarmi('logo/', $ayar['koyu_logo'] ?? '')): ?>
                                    <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-logo" style="max-height: 50px;">
                                <?php endif; ?>
                            </a> 
                        </div>
                        <div class="text-center">
                            <h4 class="mb-1 fs-22 fw-semibold">Şifremi Unuttum</h4>
                            <p class="mb-4 text-muted fw-normal">Şifrenizin sıfırlanabilmesi için sisteme kayıtlı e-posta adresinizi giriniz.</p>
                        </div>
                        
                        <form class="postForm" action="request/Auth" method="post">
                            <input type="hidden" name="postType" value="PasswordForget">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">
                            
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">E-Posta Adresiniz</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="ornek@mail.com" required>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary py-2">Sıfırlama Bağlantısı Gönder</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="giris" class="text-muted fs-13">Giriş sayfasına dön</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>var _url = '<?=URL?>';</script>
    <script src="assets/js/script.js"></script>
</body>
</html>