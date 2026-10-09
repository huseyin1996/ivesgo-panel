<?php
$siparis_kodu = $_SESSION["siparis_id"];

if (empty($siparis_kodu)) {
    header("Location: " . URL.'index');
    exit;
}

if (!empty($siparis_kodu)) {
    $sor = $db->prepare("SELECT * FROM i_siparisler WHERE siparis_kodu = ? OR id = ?");
    $sor->execute([$siparis_kodu, $siparis_kodu]);
}

if(isset($sor) && $sor->rowCount() > 0){
    $siparis = $sor->fetch(PDO::FETCH_ASSOC);
    
    $musteri   = json_decode($siparis['musteri_bilgileri'], true);
    $urunler   = json_decode($siparis['urunler'], true);
    $fatura    = json_decode($siparis['fatura_adresi'], true);
    $teslimat  = json_decode($siparis['teslimat_adresi'], true);

    if ($siparis['odeme_durumu'] != 1) {
        $db->prepare("UPDATE i_siparisler SET odeme_durumu = 1 WHERE id = ?")->execute([$siparis['id']]);
        $siparis['odeme_durumu'] = 1;
    }

    if (!$siparis || $siparis['odeme_durumu'] != 1) {
        header("Location: " . URL . "siparisler");
        exit;
    }
    unset($_SESSION["siparis_id"]);

    if ($siparis['odeme_durumu'] == "Kredi Kartı / Sanal POS") {
        $bildirimBaslik = "Yeni Sipariş Alındı!";
        $bildirimMesaj  = "Sipariş Kodu: " . $siparis['siparis_kodu'] . " - Tutar: " . fiyat($siparis['genel_toplam']);

        $stmtBildirim = $db->prepare("INSERT INTO i_bildirimler (baslik, mesaj, tip) VALUES (?, ?, ?)");
        $stmtBildirim->execute([$bildirimBaslik, $bildirimMesaj, 'siparis']);
    }
} else {
    header("Location: " . URL . "siparisler");
    exit;
}

$api    = json_decode($ayar['api_ayarlari'] ?? '{}', true);

if ((isset($api['api_type']) && $api['api_type']==1)) {
    
    // Paraşüt fatura kesme işlemleri
    if (isset($pos_ayar['parasut']['durum']) && $pos_ayar['parasut']['durum'] == 1) {
        if (file_exists('system/Api/ParasutApi.php')) {
            require_once 'system/Api/ParasutApi.php';
            $parasut = new ParasutApi($db);

            $siparisVerileri = [
                'siparis_kodu' => $siparis['siparis_kodu']
            ];

            $musteriBilgileri = [
                'ad_soyad'      => $musteri['ad_soyad'] ?? '',
                'eposta'        => $musteri['eposta'] ?? '',
                'telefon'       => $musteri['telefon'] ?? '',
                'vergi_no'      => $musteri['vergi_no'] ?? '',
                'vergi_dairesi' => $musteri['vergi_dairesi'] ?? '',
                'adres'         => $fatura['adres'] ?? ''
            ];

            $faturaSonuc = $parasut->faturaKes($siparisVerileri, $musteriBilgileri, $urunler);

            if (isset($faturaSonuc['success']) && $faturaSonuc['success']) {
                $db->prepare("UPDATE i_siparisler SET api_fatura_id = ? WHERE id = ?")->execute([$faturaSonuc['invoice_id'], $siparis['id']]);
            }
        }
    }

    if (isset($pos_ayar['bizimhesap']['durum']) && $pos_ayar['bizimhesap']['durum'] == 1) {
        if (file_exists('system/Api/BizimHesapApi.php')) {
            require_once 'system/Api/BizimHesapApi.php';
            $bizimHesap = new BizimHesapApi($db);

            $siparisVerileri = [
                'siparis_kodu' => $siparis['siparis_kodu']
            ];

            $musteriBilgileri = [
                'id'            => $siparis['id'],
                'ad_soyad'      => $musteri['ad_soyad'] ?? '',
                'eposta'        => $musteri['eposta'] ?? '',
                'telefon'       => $musteri['telefon'] ?? '',
                'vergi_no'      => $musteri['vergi_no'] ?? '',
                'vergi_dairesi' => $musteri['vergi_dairesi'] ?? '',
                'adres'         => $fatura['adres'] ?? ''
            ];

            // Önce cari kartı oluşturalım/güncelleyelim
            $bizimHesap->cariEkleVeyaGuncelle($musteriBilgileri);
            
            // Ardından faturayı keselim
            $bhFaturaSonuc = $bizimHesap->faturaKes($siparisVerileri, $musteriBilgileri, $urunler);

            if (isset($bhFaturaSonuc['success']) && $bhFaturaSonuc['success']) {
                $db->prepare("UPDATE i_siparisler SET api_fatura_id = 1 WHERE id = ?")->execute([$siparis['id']]);
            }
        }
    }

    // 3. Logo Fatura Kesme İşlemleri
    if (isset($pos_ayar['logo']['durum']) && $pos_ayar['logo']['durum'] == 1) {
        if (file_exists('system/Api/LogoApi.php')) {
            require_once 'system/Api/LogoApi.php';
            $logoApi = new LogoApi($db);

            $siparisVerileri = [
                'siparis_kodu' => $siparis['siparis_kodu']
            ];

            $musteriBilgileri = [
                'ad_soyad'      => $musteri['ad_soyad'] ?? '',
                'eposta'        => $musteri['eposta'] ?? '',
                'telefon'       => $musteri['telefon'] ?? '',
                'vergi_no'      => $musteri['vergi_no'] ?? '',
                'vergi_dairesi' => $musteri['vergi_dairesi'] ?? '',
                'adres'         => $fatura['adres'] ?? ''
            ];

            // Cari kartı senkronize et
            $logoApi->cariEkleVeyaGuncelle($musteriBilgileri);

            // Faturayı kes
            $logoFaturaSonuc = $logoApi->faturaKes($siparisVerileri, $musteriBilgileri, $urunler);

            if (isset($logoFaturaSonuc['success']) && $logoFaturaSonuc['success']) {
                $db->prepare("UPDATE i_siparisler SET api_fatura_id = 1 WHERE id = ?")->execute([$siparis['id']]);
            }
        }
    }

    // 4. Akınsoft Volvox Fatura Kesme İşlemleri
    if (isset($pos_ayar['volvox']['durum']) && $pos_ayar['volvox']['durum'] == 1) {
        if (file_exists('system/Api/VolvoxApi.php')) {
            require_once 'system/Api/VolvoxApi.php';
            $volvoxApi = new VolvoxApi($db);

            $siparisVerileri = [
                'siparis_kodu' => $siparis['siparis_kodu']
            ];

            $musteriBilgileri = [
                'id'            => $siparis['id'],
                'ad_soyad'      => $musteri['ad_soyad'] ?? '',
                'eposta'        => $musteri['eposta'] ?? '',
                'telefon'       => $musteri['telefon'] ?? '',
                'vergi_no'      => $musteri['vergi_no'] ?? '',
                'vergi_dairesi' => $musteri['vergi_dairesi'] ?? '',
                'adres'         => $fatura['adres'] ?? ''
            ];

            // Cari hesabı güncelle veya aç
            $volvoxApi->cariEkleVeyaGuncelle($musteriBilgileri);

            // Faturayı Volvox'a aktar
            $volvoxFaturaSonuc = $volvoxApi->faturaKes($siparisVerileri, $musteriBilgileri, $urunler);

            if (isset($volvoxFaturaSonuc['success']) && $volvoxFaturaSonuc['success']) {
                $db->prepare("UPDATE i_siparisler SET volvox_fatura_durumu = 1 WHERE id = ?")->execute([$siparis['id']]);
            }
        }
    }

    // Ödeme başarılı olup sipariş onaylandığı anda:
    if (isset($pos_ayar['whatsapp']['durum']) && $pos_ayar['whatsapp']['durum'] == 1) {
        if (file_exists('system/Api/WhatsAppApi.php')) {
            require_once 'system/Api/WhatsAppApi.php';
            $waApi = new WhatsAppApi($db);

            $telefon     = $musteri['telefon'] ?? '';
            $musteriAdi  = $musteri['ad_soyad'] ?? 'Değerli Müşterimiz';
            $siparisKodu = $siparis['siparis_kodu'];
            $durum       = "Ödemeniz başarıyla alındı, siparişiniz hazırlık sürecine eklendi.";

            $waApi->siparisMesajiGonder($telefon, $musteriAdi, $siparisKodu, $durum);
        }
    }
}
?>

<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0 text-success"><i class="ri-checkbox-circle-fill me-1"></i> Ödeme Başarılı! Siparişiniz Alındı</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?=URL?>">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ödeme Sonucu</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        
        <!-- BAŞARI BİLDİRİM BANNERI -->
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card bg-success-transparent border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-xl bg-success text-white rounded-circle fs-24 d-flex align-items-center justify-content-center">
                                <i class="ri-check-line"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-success mb-1">Tebrikler, ödemeniz başarıyla gerçekleştirildi!</h4>
                                <p class="text-muted mb-0"><b><?=htmlspecialchars($siparis['siparis_kodu'])?></b> numaralı siparişiniz başarıyla oluşturuldu ve hazırlık sürecine alındı.</p>
                            </div>
                        </div>
                        <div>
                            <a href="<?=URL?>" class="btn btn-success px-4"><i class="ri-home-4-line me-1"></i> Anasayfaya Dön</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-9">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card overflow-hidden shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">Satın Alınan Ürünler</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Ürün</th>
                                                <th>Stok Kodu (SKU)</th>
                                                <th class="text-center">Miktar</th>
                                                <th>Birim Fiyat</th>
                                                <th class="text-end">Satır Toplamı</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($urunler)): foreach($urunler as $u): 
                                                $urun_resim = !empty($u['resim']) ? $u['resim'] : 'assets/images/resim-yok.png';
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="lh-1">
                                                            <span class="avatar avatar-xxl border rounded">
                                                                <img src="<?=$urun_resim?>" alt="Ürün" style="object-fit:cover;">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold fs-16 text-dark"><?=htmlspecialchars($u['adi'] ?? $u['urun_adi'])?></div>
                                                            <?php if(!empty($u['varyant'])): ?>
                                                                <div class="text-muted fs-13">Varyant: <?=$u['varyant']?></div>
                                                            <?php endif; ?>
                                                            <div class="text-muted fs-12">KDV Oranı: %<?=$u['kdv'] ?? $u['kdv_orani'] ?? 20?> (<?=$u['kdv_durumu'] ?? 'Dahil'?>)</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-muted fw-semibold">
                                                        <?=htmlspecialchars($u['stok_kodu'] ?? '-')?>
                                                    </div>
                                                </td>
                                                <td class="product-quantity-container text-center fw-bold">
                                                    <?=$u['adet'] ?? $u['miktar']?> Adet
                                                </td>
                                                <td>
                                                    <?=number_format($u['fiyat'] ?? $u['birim_fiyat'], 2, ',', '.')?> <?=$siparis['para_birimi']?>
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    <?=number_format($u['satir_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?>
                                                </td>
                                            </tr>
                                            <?php endforeach; endif; ?>

                                            <tr>
                                                <td colspan="3" class="border-bottom-0"></td>
                                                <td colspan="2" class="border-bottom-0">
                                                    <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-muted">Ara Toplam :</td>
                                                                <td class="text-end fw-medium"><?=number_format($siparis['ara_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">KDV Toplam :</td>
                                                                <td class="text-end fw-medium"><?=number_format($siparis['kdv_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">Kargo Ücreti :</td>
                                                                <td class="text-end fw-medium"><?=number_format($siparis['kargo_ucreti'], 2, ',', '.')?> <?=$siparis['para_birimi']?></td>
                                                            </tr>
                                                            <?php if($siparis['indirim_toplam'] > 0): ?>
                                                            <tr>
                                                                <td class="text-muted">Toplam İndirim :</td>
                                                                <td class="text-end fw-medium text-danger">-<?=number_format($siparis['indirim_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?></td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <tr class="border-top">
                                                                <td class="fw-bold fs-14 text-dark">Genel Toplam :</td>
                                                                <td class="text-end fw-bold fs-16 text-success">
                                                                    <?=number_format($siparis['genel_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">Sipariş Süreç Durumu</div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled order-activity-list mb-0">
                                    <li>
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="w-75">
                                                <div class="fw-medium fs-15 mb-1 text-success"><i class="ri-checkbox-circle-line me-1"></i> Ödeme Başarıyla Alındı</div>
                                                <div class="text-muted fs-12">Sanal POS üzerinden ödeme onayı alındı ve sipariş kesinleşti.</div>
                                            </div>
                                            <div class="fs-12 text-end text-muted">
                                                <span><?=tarihSaat($siparis['eklenme_tarihi'])?></span> 
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pending">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="w-75">
                                                <div class="fw-medium fs-15 mb-1">Depo & Paketleme</div>
                                                <div class="text-muted fs-12">Ürünleriniz depomuzda özenle paketlenmek üzere sıraya alındı.</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">Banka Hesap Bilgilerimiz</div>
                            </div>
                            <div class="card-body">
                                <?php if ($siparis['odeme_yontemi'] == "Havale / EFT"): ?>
                                    <table border="0" class="table table-responsive">
                                        <tbody>
                                            <tr>
                                                <td>BANKA</td>
                                                <td>PARA BİRİMİ</td>
                                                <td>IBAN NO</td>
                                            </tr>
                                            <?php $banka_arr = json_decode($ayar['banka_bilgiler'] ?? '[]', true);
                                            if(!empty($banka_arr)){
                                                foreach($banka_arr as $cek){ ?> 
                                                    <tr>
                                                        <td>
                                                            <img src="assets/images/bank/<?=$cek['banka']?>.png" width="100" loading="lazy" alt="<?=$cek['banka']?> hesabımız">
                                                        </td>
                                                        <td><span><?=$cek['para_birim']?></span></td>
                                                        <td><span><?=$cek['iban']?></span></td>
                                                    </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SAĞ TARAF: TESLİMAT VE ÖDEME ÖZETİ -->
            <div class="col-xxl-3">
                <div class="row">
                    <!-- TESLİMAT BİLGİLERİ -->
                    <div class="col-xl-12">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom justify-content-between">
                                <div class="card-title fw-bold">Teslimat & Fatura Adresi</div>
                            </div>
                            <div class="card-body">
                                <span class="d-block fw-bold text-dark mb-1"><?=htmlspecialchars($musteri['ad_soyad'] ?? '-')?></span>
                                <?php if(!empty($musteri['firma_unvani'])): ?>
                                    <span class="d-block text-muted fs-12 mb-2"><?=htmlspecialchars($musteri['firma_unvani'])?></span>
                                <?php endif; ?>
                                <ul class="list-unstyled order-address-list fs-13 text-muted mb-3">
                                    <li><b>Adres:</b> <?=htmlspecialchars($fatura['adres'] ?? $teslimat['adres'] ?? 'Adres belirtilmemiş')?></li>
                                    <li><b>Telefon:</b> <?=htmlspecialchars($musteri['telefon'] ?? '-')?></li>
                                    <li><b>E-Posta:</b> <?=htmlspecialchars($musteri['eposta'] ?? '-')?></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">İşlem Onay Detayları</div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush fs-13">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Sipariş Kodu</div>
                                            <div class="fw-bold text-primary"><?=htmlspecialchars($siparis['siparis_kodu'])?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Ödeme Yöntemi</div>
                                            <div class="fw-medium"><?=htmlspecialchars($siparis['odeme_yontemi'] ?? 'Kredi Kartı')?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Ödeme Durumu</div>
                                            <span class="badge bg-success">Ödendi (Onaylandı)</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Toplam Ödenen</div>
                                            <div class="fw-bold text-success"><?=number_format($siparis['genel_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>