<?php

if (!modulAktifMi($db, 'siparisler') && !yetkisiVarMi("siparisler", 'ekle')) {
    header("Location:" . URL . "index");
}

$sepet_cek   = json_decode($ayar["sepet_ayarlari"] ?? '{}', true);
$modul       = json_decode($ayar['modul_ayarlari'] ?? '{}', true);
$min_sepet   = floatval($sepet_cek['min_sepet'] ?? 0);
$kargo_ucret = floatval($sepet_cek['kargo_ucret'] ?? 0);

$sepet_ayarlari = json_decode($ayar["sepet_ayarlari"] ?? '{}', true);

$aktif_odemeler = $sepet_ayarlari['aktif_odemeler'] ?? [];
$tum_odeme_secenekleri = [
    'kredi_karti'  => 'Kredi Kartı / Sanal POS',
    'havale_eft'   => 'Havale / EFT',
    'kapida_odeme' => 'Kapıda Ödeme',
    'nakit'        => 'Nakit / Elden',
    'cari_hesap'   => 'Cari Hesaba Yazılacak'
];

$musteriler = $db->query("SELECT * FROM i_musteriler ORDER BY musteri_adi ASC")->fetchAll(PDO::FETCH_ASSOC);


$urunler = $db->query("SELECT urun_id, stok_kodu, urun_adi, urun_fiyat, urun_indirim, urun_kdv, para_birimi, urun_stok FROM i_urunler WHERE durum = 1 ORDER BY urun_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content app-content order-page">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Manuel Sipariş Oluştur</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Siparişler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sipariş Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <form class="postForm" action="request/orders" method="post" id="siparisFormu">
            <input type="hidden" name="postType" value="Add">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

            <div class="row">

                <div class="col-xl-12 mb-4">
                    <div class="card custom-card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <div class="card-title fw-bold"><i class="bi bi-person-badge"></i> Müşteri & Fatura Bilgileri</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-xl-12 mb-2">
                                    <label class="form-label fw-bold text-primary">Kayıtlı Müşteri Seç (Otomatik Doldurur)</label>
                                    <select class="form-select border-primary choices-select" data-trigger name="musteri_id" id="musteri_sec">
                                        <option value="0">--- Yeni / Kayıtsız Misafir Müşteri ---</option>
                                        <?php foreach($musteriler as $m): ?>
                                            <option value="<?=$m['id']?>"><?=$m['musteri_adi']?> <?=(!empty($m['unvan']) ? ' - '.$m['unvan'] : '')?> (<?=$m['telefon'] ?? $m['gsm']?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle"></i> Kayıtlı müşteri seçerseniz aşağıdaki alanlar otomatik dolar. Boş alanları elle tamamlayabilirsiniz.</small>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Müşteri Tipi</label>
                                    <select class="form-select bg-white" name="musteri_tipi" id="f_musteri_tipi">
                                        <option value="bireysel">Bireysel</option>
                                        <option value="kurumsal">Kurumsal</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="ad_soyad" id="f_ad_soyad" required>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 kurumsal-alan">
                                    <label class="form-label text-muted small">Firma Ünvanı</label>
                                    <input type="text" class="form-control bg-white" name="firma_unvani" id="f_firma_unvani">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">E-Posta Adresi</label>
                                    <input type="email" class="form-control bg-white" name="eposta" id="f_eposta">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Telefon No</label>
                                    <input type="text" class="form-control bg-white" name="telefon" id="f_telefon">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 kurumsal-alan">
                                    <label class="form-label text-muted small">Vergi Dairesi</label>
                                    <input type="text" class="form-control bg-white" name="vergi_dairesi" id="f_vergi_dairesi">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Vergi No / TC Kimlik</label>
                                    <input type="text" class="form-control bg-white" name="vergi_no" id="f_vergi_no">
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 mt-3">
                                    <label class="form-label text-muted small">Fatura Açık Adresi</label>
                                    <textarea class="form-control bg-white" name="fatura_adres" id="f_fatura_adres" rows="2"></textarea>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mt-3">
                                    <label class="form-label text-muted small">Teslimat Açık Adresi (Farklıysa)</label>
                                    <textarea class="form-control bg-white" name="teslimat_adres" id="f_teslimat_adres" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-12">
                    <div class="card custom-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <div class="card-title fw-bold"><i class="bi bi-cart-plus"></i> Sipariş Edilecek Ürünler</div>
                            <button type="button" class="btn btn-sm btn-success fw-bold px-3 shadow-sm" id="satirEkleBtn">
                                <i class="bi bi-plus-lg"></i> Yeni Satır Ekle
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="urunTablosu">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="35%">Ürün Seçin</th>
                                            <th class="text-center" width="15%">Birim Fiyat</th>
                                            <th class="text-center" width="15%">KDV Tipi</th>
                                            <th class="text-center" width="15%">Miktar</th>
                                            <th class="text-end" width="15%">Satır Toplam</th>
                                            <th class="text-center" width="5%">Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody id="urunSatirlari">
                                    </tbody>
                                </table>
                            </div>
                            <div id="bosSepetUyarisi" class="p-4 text-center text-muted">
                                <i class="bi bi-bag-x fs-1 opacity-50 mb-2 d-block"></i>
                                Siparişte henüz ürün yok. Lütfen "Yeni Satır Ekle" butonunu kullanın.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12">
                    
                    <div class="card custom-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom">
                            <div class="card-title fw-bold"><i class="bi bi-calculator"></i> Tutar & Lojistik</div>
                        </div>
                        <div class="card-body">

                            <?php if (!empty($modul) && isset($modul['kampanya_kupon']) && $modul['kampanya_kupon'] == 1): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Kampanya / Kupon Uygula</label>
                                    <select class="form-select" name="kampanya_id" id="kampanya_sec">
                                        <option value="0" data-tur="" data-deger="0" data-min="0">-- Kampanya Seçilmedi --</option>
                                        <?php 
                                        $aktif_kampanyalar = $db->query("SELECT * FROM i_kampanyalar WHERE durum = 1 ORDER BY kampanya_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($aktif_kampanyalar as $kp): 
                                        ?>
                                            <option value="<?=$kp['id']?>" 
                                                    data-tur="<?=$kp['kampanya_turu']?>" 
                                                    data-deger="<?=$kp['indirim_orani']?>" 
                                                    data-min="<?=$kp['min_sepet_tutar']?>">
                                                <?=$kp['kampanya_adi']?> <?=(!empty($kp['kampanya_kodu']) ? '('.$kp['kampanya_kodu'].')' : '')?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif ?>
                            
                            <div class="row g-2 mb-3 pb-3 border-bottom">
                                <div class="col-6">
                                    <label class="form-label text-muted small">Kargo Ücreti (₺)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" class="form-control text-end finans-input" name="kargo_ucreti" id="kargo_ucreti" value="0.00">
                                        <button class="btn btn-outline-secondary" type="button" id="kargoOtoBtn" title="Otomatik Hesaplamaya Dön"><i class="bi bi-arrow-repeat"></i></button>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size:10px;">Limit: <?=number_format($min_sepet,2)?> ₺</small>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small">Manuel İndirim (₺)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm text-end finans-input" name="indirim_toplam" id="indirim_toplam" value="0.00">
                                </div>
                            </div>


                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ürünler Ara Toplam:</span>
                                <span class="fw-semibold" id="ozetAraToplam">0,00 ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">KDV Toplamı:</span>
                                <span class="fw-semibold" id="ozetKdvToplam">0,00 ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 text-primary">
                                <span class="text-muted">Kargo & İndirim Etkisi:</span>
                                <span class="fw-semibold" id="ozetKargoIndirim">0,00 ₺</span>
                            </div>
                            
                            <div class="p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-15 text-dark">Genel Toplam:</span>
                                <span class="fw-bold fs-20 text-success" id="ozetGenelToplam">0,00 ₺</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">Sipariş Durumu</label>
                                <select class="form-select" name="siparis_durumu">
                                    <option value="0" selected>Yeni Sipariş (Onay Bekliyor)</option>
                                    <option value="1">Hazırlanıyor</option>
                                    <option value="2">Kargoya Verildi</option>
                                    <option value="3">Teslim Edildi</option>
                                    <option value="4">İptal Edildi</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small">Ödeme Yöntemi</label>
                                <select class="form-select" name="odeme_yontemi" required>
                                    <option value="" disabled selected>Ödeme Yöntemi Seçiniz</option>
                                    <?php foreach ($tum_odeme_secenekleri as $key => $baslik): ?>
                                        <?php 
                                            if (isset($aktif_odemeler[$key]) && $aktif_odemeler[$key] == '1'): 
                                        ?>
                                            <option value="<?=$baslik?>"><?=$baslik?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">Ödeme Durumu</label>
                                <select class="form-select" name="odeme_durumu">
                                    <option value="0" selected>Ödeme Bekliyor</option>
                                    <option value="1">Ödeme Alındı (Ödendi)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">Yönetici Sipariş Notu</label>
                                <textarea class="form-control" name="admin_notu" rows="2" placeholder="Örn: Müşteri acil gönderim istedi..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-16 shadow-sm fw-bold">
                                <i class="bi bi-check-circle-fill me-2"></i> Siparişi Tamamla & Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.siparisMusterileri = <?=json_encode($musteriler, JSON_UNESCAPED_UNICODE)?>;
    window.siparisUrunleri = <?=json_encode($urunler, JSON_UNESCAPED_UNICODE)?>;
    window.kargoMinLimit = <?=$min_sepet?>;
    window.kargoStandartUcret = <?=$kargo_ucret?>;
</script>