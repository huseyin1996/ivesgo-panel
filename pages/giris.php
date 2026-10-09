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

<body  class="auth-body-card">

    <div class="row authentication authentication-cover-main mx-0 p-3 justify-content-center align-items-center">
        <div class="col-xxl-8 col-lg-7 col-md-8 col-sm-10">
            <div class="mb-4 pb-2 d-flex align-items-center justify-content-center"> 
                <a href="<?=URL?>"> 

                    <?php if (resimVarmi('logo/', $ayar['koyu_logo'])): ?>
                        <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-logo">
                        <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="logo" class="desktop-dark d-none">
                    <?php endif; ?>
                </a> 
            </div>
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="row gx-0">
                        <div class="col-xxl-6 col-xl-12 my-auto">
                            <div class="card custom-card border-0 shadow-none my-4 p-4">
                                <div class="card-body p-sm-5 m-sm-3">
                                    <div>
                                        <h4 class="mb-1 fs-22 fw-semibold">Hoşgeldiniz, CRM Girişi Yapınız</h4>
                                        <p class="mb-4 text-muted fw-normal">Giriş bilgileriniz ile CRM sistemine giriş yapabilirsiniz.</p>
                                    </div>
                                    <form id="login" action="request/login" method="post">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                        <div class="row gy-3">
                                            <div class="col-xl-12">
                                                <label for="email" class="form-label text-default">E-Posta Adresiniz / Kullanıcı Adı</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="E-Posta veya Kullanıcı Adınızı Giriniz" required>
                                            </div>
                                            <div class="col-xl-12 mb-2">
                                                <label for="password" class="form-label text-default d-block">Şifreniz</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi Giriniz" required>
                                                    <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" value="1" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Beni Hatırla
                                                        </label>
                                                        <a href="reset-password-basic.html" class="float-end link-danger fw-medium fs-12">Şifrenizi mi unuttunuz ?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid mt-3">
                                            <button type="submit" class="btn btn-primary py-2" aria-label="Giriş Yap">Giriş Yap</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-12 col-lg-12 d-xxl-block d-none px-0">
                            <div class="authentication-cover overflow-hidden rounded-e bg-dark">
                                <div class="authentication-cover-background">
                                    <?php if (resimVarmi('system/', $ayar['giris_resim'])): ?>
                                        <img src="<?=resimGetir('system/', $ayar['giris_resim'])?>" alt="Resim">
                                    <?php endif; ?>
                                </div>
                                <div class="authentication-cover-content mt-auto text-center">
                                    <div class="p-5 auth-side-card mb-4 rounded">
                                        <h3 class="fw-semibold lh-base text-fixed-white"><?=$dil['firma_adi']?> CRM Sistemi</h3>
                                        <p class="mb-4 text-fixed-white fs-16 op-7">CRM sistemimize giriş yapmak ve ürünlerimizi incelemek için hemen oturum açabilirsiniz.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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