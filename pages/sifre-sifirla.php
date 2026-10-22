<?php
$token = trim($_GET['token'] ?? '');
$gecerliToken = false;
$uye_id = 0;

if (!empty($token)) {
    // Token veritabanında var mı ve süresi geçmemiş mi kontrol edelim (Örn: 1 saat geçerlilik)
    $stmt = $db->prepare("SELECT uye_id, sifre_kod_tarih FROM i_uyeler WHERE sifre_kod = ?");
    $stmt->execute([$token]);
    $uye = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($uye) {
        $gecerliToken = true;
        $uye_id = $uye['uye_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<head>
    <base href="<?=URL?>">
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yeni Şifre Belirleme | <?=$ayar['site_baslik'] ?? 'Klinik Portal'?></title>
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

                        <?php if (!$gecerliToken): ?>
                            <div class="text-center">
                                <div class="alert alert-danger" role="alert">
                                    Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı! Lütfen tekrar şifremi unuttum adımlarını takip edin.
                                </div>
                                <a href="sifre-unuttum" class="btn btn-primary mt-3">Yeni Kod Talep Et</a>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <h4 class="mb-1 fs-22 fw-semibold">Yeni Şifre Belirleme</h4>
                                <p class="mb-4 text-muted fw-normal">Lütfen hesabınız için güvenli bir yeni şifre giriniz.</p>
                            </div>
                            
                            <form class="postForm" action="request/Auth" method="post">
                                <input type="hidden" name="postType" value="PasswordResetUpdate">
                                <input type="hidden" name="token" value="<?=htmlspecialchars($token)?>">
                                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">
                                
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="yeni_sifre" class="form-label text-default">Yeni Şifre</label>
                                        <input type="password" class="form-control" id="yeni_sifre" name="yeni_sifre" placeholder="En az 6 karakter" required minlength="6">
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="yeni_sifre_tekrar" class="form-label text-default">Yeni Şifre (Tekrar)</label>
                                        <input type="password" class="form-control" id="yeni_sifre_tekrar" name="yeni_sifre_tekrar" placeholder="Şifrenizi tekrar girin" required minlength="6">
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success py-2">Şifreyi Güncelle</button>
                                </div>
                            </form>
                        <?php endif; ?>
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