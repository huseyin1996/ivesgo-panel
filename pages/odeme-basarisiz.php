<?php
if (!isset($_SESSION["siparis_id"])) {
    header("Location: " . URL . "sepetim");
    exit;
}

$siparis_kodu = $_SESSION["siparis_id"];

$siparis_sorgu = $db->prepare("SELECT * FROM i_siparisler WHERE siparis_kodu = ?");
$siparis_sorgu->execute([$siparis_kodu]);
$siparis_cek = $siparis_sorgu->fetch(PDO::FETCH_ASSOC);

$hata_mesaji = $_GET['reason'] ?? $_GET['message'] ?? 'Ödeme işlemi sırasında bir hata oluştu veya banka onay vermedi.';

unset($_SESSION["siparis_id"]);
?>


<div class="main-content app-content">

    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Ödeme Başarısız</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Siparişler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ödeme Başarısız</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <div class="avatar avatar-xxl bg-danger-transparent text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 40px;">
                                <i class="ri-close-circle-fill"></i>
                            </div>
                        </div>

                        <h3 class="fw-bold text-danger mb-2">Ödeme Başarısız Oldu</h3>
                        <p class="text-muted fs-15 mb-4">
                            İşleminiz tamamlanamadı. Lütfen kart bilgilerinizi kontrol edip tekrar deneyiniz.
                        </p>

                        <div class="alert alert-danger border-0 bg-danger-transparent text-danger p-3 mb-4 text-start">
                            <div class="d-flex align-items-center">
                                <i class="ri-error-warning-line fs-20 me-2"></i>
                                <div>
                                    <strong class="d-block">Hata Açıklaması:</strong>
                                    <span class="fs-14"><?=$hata_mesaji?></span>
                                </div>
                            </div>
                        </div>

                        <?php if ($siparis_cek): ?>
                            <div class="bg-light p-3 rounded mb-4 text-start">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Sipariş Kodu:</span>
                                    <strong class="text-dark"><?=$siparis_cek['siparis_kodu']?></strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Ödenmeye Çalışılan Tutar:</span>
                                    <strong class="text-dark"><?=fiyat($siparis_cek['genel_toplam'])?> <?=$siparis_cek['para_birimi']?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="odeme" class="btn btn-primary px-4">
                                <i class="ri-refresh-line me-1"></i> Tekrar Dene / Ödeme Sayfasına Dön
                            </a>
                            <a href="siparis-duzenle/<?=$siparis_cek['id']?>" class="btn btn-outline-secondary px-3">
                                <i class="ri-shopping-cart-line me-1"></i> Sepete Dön
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>