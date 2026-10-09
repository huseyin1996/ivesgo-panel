<?php
$siparis_kodu = $_GET['kod'] ?? ($_SESSION["siparis_id"] ?? '');

if (empty($siparis_kodu)) {
    header("Location: " . URL . "sepetim");
    exit;
}
$siparis_sorgu = $db->prepare("SELECT * FROM i_siparisler WHERE siparis_kodu = ? AND odeme_durumu = 0");
$siparis_sorgu->execute([$siparis_kodu]);

if (!$siparis_sorgu->rowCount()) {
    header("Location: " . URL . "sepetim");
    exit;
}

$siparis_cek = $siparis_sorgu->fetch(PDO::FETCH_ASSOC);

$musteri_bilgileri   = json_decode($siparis_cek["musteri_bilgileri"] ?? '{}', true);
$teslimat_bilgileri  = json_decode($siparis_cek["teslimat_adresi"] ?? '{}', true);
$fatura_bilgileri    = json_decode($siparis_cek["fatura_adresi"] ?? '{}', true);
$siparis_bilgileri   = json_decode($siparis_cek["urunler"] ?? '{}', true);

$ad_soyad  = $musteri_bilgileri["ad_soyad"] ?? 'Değerli Müşterimiz';
$telefon   = $musteri_bilgileri["telefon"] ?? '';
$eposta    = $musteri_bilgileri["eposta"] ?? '';

$adres     = $teslimat_bilgileri["adres"] ?? '';
$il_id     = $teslimat_bilgileri["il"] ?? 0;
$ilce_id   = $teslimat_bilgileri["ilce"] ?? 0;

$sehir_adi = 'Istanbul';
if ($il_id > 0) {
    $sehir_sorgu = $db->prepare("SELECT il_adi FROM sehirler WHERE il_id = ?");
    $sehir_sorgu->execute([$il_id]);
    $sehir_cek = $sehir_sorgu->fetch(PDO::FETCH_ASSOC);
    if ($sehir_cek) {
        $sehir_adi = $sehir_cek['il_adi'];
    }
}

$toplam_tutar = floatval($siparis_cek['genel_toplam'] > 0 ? $siparis_cek['genel_toplam'] : ($siparis_cek['fiyat'] ?? 0));

$gelen_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

require_once 'system/SanalPos.php';
$sanalPos = new SanalPos($db);

$siparisVeriPaketi = [
    'id'           => $siparis_cek['id'],
    'takip_no'     => $siparis_cek['siparis_kodu'],
    'fiyat'        => $toplam_tutar,
    'para_birimi'  => $siparis_cek['para_birimi'] ?? 'TRY'
];

$teslimatVeriPaketi = [
    'ad_soyad'     => $ad_soyad,
    'telefon'      => $telefon,
    'email'        => $eposta,
    'adres'        => $adres,
    'posta_kodu'   => $teslimat_bilgileri["posta_kodu"] ?? '34000'
];

$ekVeriler = [
    'siparis_id'   => $siparis_cek['id'],
    'gelen_ip'     => $gelen_ip,
    'sehir_adi'    => $sehir_adi,
    'musteri_id'   => $siparis_cek['musteri_id']
];

$odemeSonuc = $sanalPos->odemeBaslat($siparisVeriPaketi, $teslimatVeriPaketi, ['sepet' => ['urunler' => $siparis_bilgileri]], $ekVeriler);
?>

<div class="main-content app-content live-page" data-page="index">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-semibold fs-20 mb-0">Ödeme Yapın</h1>
                <p class="text-muted fs-13 mb-0">Siparişinizin ödemesini yapabilirisiniz</p>
            </div>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ödeme Yapın</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fs-18"><i class="ri-secure-payment-line me-2"></i> Güvenli Ödeme Ekranı</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="alert alert-light border mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sipariş Kodu:</span>
                                <strong><?=$siparis_cek['siparis_kodu']?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ödeme Yöntemi:</span>
                                <strong><?=$siparis_cek['odeme_yontemi']?></strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Ödenecek Tutar:</span>
                                <strong class="text-success fs-18"><?=number_format($siparis_cek['genel_toplam'], 2, ',', '.')?> <?=$siparis_cek['para_birimi']?></strong>
                            </div>
                        </div>
                        <?php if (isset($odemeSonuc['success']) && $odemeSonuc['success']): ?>

                            <?php if ($odemeSonuc['gateway'] == 'paytr'): ?>
                                <div class="text-center">
                                    <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                                    <iframe src="https://www.paytr.com/odeme/guvenli/<?=$odemeSonuc['token']?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%; min-height: 500px;"></iframe>
                                    <script>iFrameResize({}, '#paytriframe');</script>
                                </div>

                            <?php elseif ($odemeSonuc['gateway'] == 'iyzico'): ?>
                                <!-- İyzico Checkout Form Alanı -->
                                <div id="iyzipay-checkout-form" class="responsive">
                                    <?=$odemeSonuc['checkout_content']?>
                                </div>

                            <?php elseif ($odemeSonuc['gateway'] == 'moka'): ?>
                                <div class="checkout-shell">
                                    <div class="eyebrow">Ödeme</div>
                                    <h1 class="page-title">Kart bilgilerinizi girin</h1>
                                    <p class="page-sub">Bilgileriniz 256-bit şifreleme ile bankanıza iletilir, sunucumuzda saklanmaz.</p>

                                    <div class="checkout-card mt-10">
                                        <div class="row g-0">

                                            <div class="col-md-5">
                                                <div class="summary-panel">
                                                    <div>
                                                        <div class="brand-row">
                                                            Garaj Depo
                                                        </div>

                                                        <div class="amount-block">
                                                            <div class="amount-label">Çekilecek Tutar</div>
                                                            <div class="amount-value" id="previewAmount"><?=fiyat($siparis_cek['fiyat'])?></div>
                                                        </div>

                                                        <div class="card-scene">
                                                            <div class="card-flip" id="cardFlip">
                                                                <div class="card-face front">
                                                                    <div class="card-top-row">
                                                                        <div class="chip"></div>
                                                                        <div class="network-badge" id="networkBadge">&nbsp;</div>
                                                                    </div>
                                                                    <div class="card-number-line" id="previewNumber">•••• •••• •••• ••••</div>
                                                                    <div class="card-bottom-row">
                                                                        <div>
                                                                            <div class="card-label">Kart Sahibi</div>
                                                                            <div class="card-value" id="previewName">AD SOYAD</div>
                                                                        </div>
                                                                        <div>
                                                                            <div class="card-label">S.K.T.</div>
                                                                            <div class="card-value" id="previewExpiry">AA/YY</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-face back">
                                                                    <div class="magstripe"></div>
                                                                    <div class="cvv-strip">
                                                                        <div class="cvv-box" id="previewCvv">•••</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="trust-row">
                                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6 10V8a6 6 0 1112 0v2M5 10h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1v-9a1 1 0 011-1z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        3D Secure ile korumalı ödeme
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <div class="form-panel">
                                                    <form method="post" action="request/odeme-moka" id="odemeForm" class="paymentPost" autocomplete="off">

                                                        <div class="mb-20">
                                                            <label class="field-label" for="name">Kredi Kartı Üzerindeki İsim</label>
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Ad Soyad" autocomplete="off">
                                                        </div>

                                                        <div class="mb-20">
                                                            <label class="field-label" for="pan">Kredi Kart Numarası</label>
                                                            <div class="input-affix">
                                                                <input type="text" class="form-control" id="pan" name="pan" maxlength="19" placeholder="0000 0000 0000 0000" inputmode="numeric" autocomplete="off">
                                                                <span class="affix-icon" id="cardIcon">
                                                                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none"><rect x="0.5" y="0.5" width="21" height="14" rx="2.5" stroke="#B9C0CC"/><rect x="3" y="4" width="6" height="2" rx="1" fill="#B9C0CC"/></svg>
                                                                </span>
                                                            </div>
                                                            <div class="field-error" id="panError">Kart numarası eksik görünüyor.</div>
                                                        </div>

                                                        <div class="row mt-20">
                                                            <div class="col-7 mb-3">
                                                                <label class="field-label">Son Kullanma Tarihi</label>
                                                                <div class="d-flex gap-2">
                                                                    <select class="form-select" name="month" id="expMonth"></select>
                                                                    <select class="form-select" name="year" id="expYear"></select>
                                                                </div>
                                                            </div>
                                                            <div class="col-5 mb-20">
                                                                <label class="field-label" for="cv2">Güvenlik Kodu</label>
                                                                <div class="input-affix">
                                                                    <input type="text" class="form-control" id="cv2" name="cv2" maxlength="3" placeholder="CVV" inputmode="numeric" autocomplete="off">
                                                                    <span class="affix-icon" style="cursor:help;" title="Kartın arkasındaki 3 haneli kod">
                                                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9.5" stroke="#B9C0CC"/><path d="M12 11v5.5" stroke="#B9C0CC" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="8" r="1" fill="#B9C0CC"/></svg>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="pay-btn mt-10" id="devamEt">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 10V8a6 6 0 1112 0v2M5 10h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1v-9a1 1 0 011-1z" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                            Güvenli Ödemeyi Tamamla
                                                        </button>

                                                        <div class="secure-note">
                                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M6 10V8a6 6 0 1112 0v2M5 10h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1v-9a1 1 0 011-1z" stroke="currentColor" stroke-width="1.7"/></svg>
                                                            Bilgileriniz bankanızın 3D Secure sayfasında doğrulanır.
                                                        </div>

                                                        <div class="accepted-row">
                                                            <span class="accepted-label">Kabul edilen kartlar</span>
                                                            <span class="mini-badge">VISA</span>
                                                            <span class="mini-badge">MASTERCARD</span>
                                                            <span class="mini-badge">TROY</span>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="alert alert-danger text-center my-3">
                                <h5 class="alert-heading"><i class="ri-error-warning-line"></i> Ödeme Başlatılamadı</h5>
                                <p class="mb-0"><?=$odemeSonuc['message'] ?? 'Sistem yapılandırmasında bir hata oluştu.'?></p>
                            </div>
                            <div class="text-center mt-3">
                                <a href="<?=URL?>sepetim" class="btn btn-secondary btn-sm"><i class="ri-arrow-left-line"></i> Sepete Geri Dön</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>