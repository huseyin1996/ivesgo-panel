<?php

if (!modulAktifMi($db, 'siparisler') &&!yetkisiVarMi("siparisler", 'goruntule')) {
    header("Location:" . URL . "index");
}
$sor = $db->prepare("SELECT * FROM i_siparisler WHERE id = :id");
$sor->execute(["id" => $par[1]]);

if($sor->rowCount() > 0){
    $siparis = $sor->fetch(PDO::FETCH_ASSOC);
    
    // JSON verilerini diziye çeviriyoruz
    $musteri   = json_decode($siparis['musteri_bilgileri'], true);
    $urunler   = json_decode($siparis['urunler'], true);
    $fatura    = json_decode($siparis['fatura_adresi'], true);
    $teslimat  = json_decode($siparis['teslimat_adresi'], true);
} else {
    header("Location: " . URL . "siparisler/");
    exit;
}
?>

<div class="main-content app-content">
      <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sipariş Detayı: <?=htmlspecialchars($siparis['siparis_kodu'])?></h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Siparişler</a></li>
                <li class="breadcrumb-item"><a href="siparisler/">Tüm Siparişler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sipariş Detayı</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <!-- SOL TARAF: ÜRÜNLER VE ZAMAN ÇİZELGESİ (TIMELINE) -->
            <div class="col-xxl-9">
                <div class="row">
                    <!-- ÜRÜN LİSTESİ -->
                    <div class="col-xl-12">
                        <div class="card custom-card overflow-hidden shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap align-middle mb-0">
                                        <thead class="table">
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
                                                // Sizin sepet/json yapınızdaki resim veya varsayılan görsel
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
                                                        <?=htmlspecialchars($u['stok_kodu'])?>
                                                    </div>
                                                </td>
                                                <td class="product-quantity-container text-center fw-bold">
                                                    <?=$u['adet'] ?? $u['miktar']?>
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

                    <!-- SİPARİŞ ZAMAN ÇİZELGESİ (TİMELINE) -->
                    <div class="col-xl-7">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">Sipariş Akışı & Geçmişi</div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled order-activity-list">
                                    <li>
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="w-75">
                                                <div class="fw-medium fs-15 mb-1">Sipariş Oluşturuldu</div>
                                                <div class="text-muted fs-12">Sipariş sisteme başarıyla kaydedildi ve işleme alındı.</div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="d-block mb-1"><?=tarihSaat($siparis['eklenme_tarihi'])?></span> 
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Ödeme Durumuna Göre Dinamik Adım -->
                                    <li class="<?=($siparis['odeme_durumu'] == 1 ? '' : 'pending')?>">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="w-75">
                                                <div class="fw-medium fs-15 mb-1">Ödeme Durumu</div>
                                                <div class="text-muted fs-12">
                                                    <?=$siparis['odeme_durumu'] == 1 ? 'Ödeme başarıyla onaylandı ve tahsil edildi.' : 'Ödeme bekleniyor.'?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Sipariş Durum Adımı -->
                                    <li>
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="w-75">
                                                <div class="fw-medium fs-15 mb-1">Mevcut Aşama: <?=htmlspecialchars($siparis['siparis_durumu'])?></div>
                                                <div class="text-muted fs-12">Lojistik ve hazırlık süreci güncel durumdadır.</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FATURA VE TESLİMAT ADRESLERİ -->
                    <div class="col-xl-5">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom justify-content-between">
                                <div class="card-title fw-bold">Fatura & Teslimat Bilgileri</div>
                            </div>
                            <div class="card-body">
                                <span class="d-block fw-bold text-dark mb-1"><?=htmlspecialchars($musteri['ad_soyad'] ?? '-')?></span>
                                <?php if(!empty($musteri['firma_unvani'])): ?>
                                    <span class="d-block text-muted fs-12 mb-2"><?=htmlspecialchars($musteri['firma_unvani'])?></span>
                                <?php endif; ?>
                                <ul class="list-unstyled order-address-list fs-13 text-muted mb-3">
                                    <li><?=htmlspecialchars($fatura['adres'] ?? 'Adres belirtilmemiş')?></li>
                                    <li>Telefon: <?=htmlspecialchars($musteri['telefon'] ?? '-')?></li>
                                    <li>E-Posta: <?=htmlspecialchars($musteri['eposta'] ?? '-')?></li>
                                </ul>
                                <?php if(!empty($siparis['kargo_firmasi'])): ?>
                                    <hr>
                                    <span class="d-block fw-bold text-dark mb-1">Kargo Bilgisi</span>
                                    <span class="d-block text-muted fs-13"><?=htmlspecialchars($siparis['kargo_firmasi'])?> - Takip No: <b><?=htmlspecialchars($siparis['kargo_takip_no'] ?? 'Yok')?></b></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SAĞ TARAF: MÜŞTERİ DETAYLARI VE ÖDEME BİLGİLERİ -->
            <div class="col-xxl-3">
                <div class="row">
                    <!-- MÜŞTERİ KARTI -->
                    <div class="col-xl-12">
                        <div class="card custom-card overflow-hidden shadow-sm border-0">
                            <div class="card-header bg-white border-bottom justify-content-between">
                                <div class="card-title fw-bold">Müşteri Profili</div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="fs-13 text-muted"><i class="ri-user-line me-2 fs-14"></i>Ad Soyad</div>
                                            <div class="fw-medium text-dark"><?=htmlspecialchars($musteri['ad_soyad'] ?? '-')?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="fs-13 text-muted"><i class="ri-mail-line me-2 fs-14"></i>E-Posta</div>
                                            <div class="fw-medium text-dark"><?=htmlspecialchars($musteri['eposta'] ?? '-')?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="fs-13 text-muted"><i class="ri-phone-line me-2 fs-14"></i>Telefon</div>
                                            <div class="fw-medium text-dark"><?=htmlspecialchars($musteri['telefon'] ?? '-')?></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- ÖDEME BİLGİLERİ KARTI -->
                    <div class="col-xl-12">
                        <div class="card custom-card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <div class="card-title fw-bold">Ödeme & İşlem Bilgileri</div>
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
                                            <div class="fw-medium"><?=htmlspecialchars($siparis['odeme_yontemi'] ?? 'Belirtilmemiş')?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Ödeme Durumu</div>
                                            <span class="badge <?=$siparis['odeme_durumu'] == 1 ? 'bg-success' : 'bg-warning text-dark'?>">
                                                <?=$siparis['odeme_durumu'] == 1 ? 'Ödendi' : 'Bekliyor'?>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">Ödenen Tutar</div>
                                            <div class="fw-bold text-success"><?=number_format($siparis['genel_toplam'], 2, ',', '.')?> <?=$siparis['para_birimi']?></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted">İşlem IP Adresi</div>
                                            <div class="fw-medium text-muted"><?=htmlspecialchars($siparis['ip_adresi'] ?? '-')?></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php if(!empty($siparis['admin_notu'])): ?>
                    <div class="col-xl-12">
                        <div class="card custom-card  border-0 shadow-sm">
                            <div class="card-header bg-transparent border-bottom">
                                <div class="card-title fw-bold text-dark"><i class="bi bi-journal-text me-1"></i> Yönetici İç Notu</div>
                            </div>
                            <div class="card-body fs-13 text-muted">
                                <?=nl2br(htmlspecialchars($siparis['admin_notu']))?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>