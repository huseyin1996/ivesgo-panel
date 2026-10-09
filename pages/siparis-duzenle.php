<?php
if (!modulAktifMi($db, 'siparisler') && !yetkisiVarMi("siparisler", 'duzenle')) {
    header("Location:" . URL . "index");
}

$sepet_cek   = json_decode($ayar["sepet_ayarlari"] ?? '{}', true);
$min_sepet   = floatval($sepet_cek['min_sepet'] ?? 0);
$kargo_ucret = floatval($sepet_cek['kargo_ucret'] ?? 0);
$modul       = json_decode($ayar['modul_ayarlari'] ?? '{}', true);

$sepet_ayarlari = json_decode($ayar_cek["sepet_ayarlari"] ?? '{}', true);
$aktif_odemeler = $sepet_ayarlari['aktif_odemeler'] ?? [];

$tum_odeme_secenekleri = [
    'kredi_karti'  => 'Kredi Kartı / Sanal POS',
    'havale_eft'   => 'Havale / EFT',
    'kapida_odeme' => 'Kapıda Ödeme',
    'nakit'        => 'Nakit / Elden',
    'cari_hesap'   => 'Cari Hesaba Yazılacak'
];

$sor = $db->prepare("SELECT * FROM i_siparisler WHERE id = :id");
$sor->execute(["id" => $par[1]]);
if($sor->rowCount() > 0){
    $siparis = $sor->fetch(PDO::FETCH_ASSOC);
    $musteri_bilgi = json_decode($siparis['musteri_bilgileri'], true);
    $kayitli_urunler = json_decode($siparis['urunler'], true);
    $fatura_bilgi = json_decode($siparis['fatura_adresi'], true);
    $teslimat_bilgi = json_decode($siparis['teslimat_adresi'], true);
} else {
    header("Location:../siparisler/");
    exit;
}


$musteriler = $db->query("SELECT * FROM i_musteriler ORDER BY musteri_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
$urunler = $db->query("SELECT urun_id, stok_kodu, urun_adi, urun_fiyat, urun_indirim, urun_kdv, para_birimi, urun_stok FROM i_urunler WHERE durum = 1 ORDER BY urun_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content app-content order-page">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sipariş Düzenle (<?=htmlspecialchars($siparis['siparis_kodu'])?>)</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Siparişler</a></li>
                <li class="breadcrumb-item"><a href="siparisler/">Tüm Siparişler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sipariş Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <form class="postForm" action="request/orders" method="post" id="siparisFormu">
            <input type="hidden" name="postType" value="Edit">
            <input type="hidden" name="value" value="<?=$siparis['id']?>">
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
                                    <label class="form-label fw-bold text-primary">Kayıtlı Müşteri Seç</label>
                                    <select class="form-select border-primary choices-select" data-trigger name="musteri_id" id="musteri_sec">
                                        <option value="0">--- Kayıtsız / Misafir Müşteri ---</option>
                                        <?php foreach($musteriler as $m): ?>
                                            <option value="<?=$m['id']?>" <?=($siparis['musteri_id'] == $m['id'] ? 'selected' : '')?>>
                                                <?=$m['musteri_adi']?> <?=(!empty($m['unvan']) ? ' - '.$m['unvan'] : '')?> (<?=$m['telefon'] ?? $m['gsm']?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Müşteri Tipi</label>
                                    <select class="form-select bg-white" name="musteri_tipi" id="f_musteri_tipi">
                                        <option value="bireysel" <?=($musteri_bilgi['musteri_tipi'] == 'bireysel' ? 'selected' : '')?>>Bireysel</option>
                                        <option value="kurumsal" <?=($musteri_bilgi['musteri_tipi'] == 'kurumsal' ? 'selected' : '')?>>Kurumsal</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-white" name="ad_soyad" id="f_ad_soyad" value="<?=htmlspecialchars($musteri_bilgi['ad_soyad'] ?? '')?>" required>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 kurumsal-alan">
                                    <label class="form-label text-muted small">Firma Ünvanı</label>
                                    <input type="text" class="form-control bg-white" name="firma_unvani" id="f_firma_unvani" value="<?=htmlspecialchars($musteri_bilgi['firma_unvani'] ?? '')?>">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">E-Posta Adresi</label>
                                    <input type="email" class="form-control bg-white" name="eposta" id="f_eposta" value="<?=htmlspecialchars($musteri_bilgi['eposta'] ?? '')?>">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Telefon No</label>
                                    <input type="text" class="form-control bg-white" name="telefon" id="f_telefon" value="<?=htmlspecialchars($musteri_bilgi['telefon'] ?? '')?>">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 kurumsal-alan">
                                    <label class="form-label text-muted small">Vergi Dairesi</label>
                                    <input type="text" class="form-control bg-white" name="vergi_dairesi" id="f_vergi_dairesi" value="<?=htmlspecialchars($musteri_bilgi['vergi_dairesi'] ?? '')?>">
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label class="form-label text-muted small">Vergi No / TC Kimlik</label>
                                    <input type="text" class="form-control bg-white" name="vergi_no" id="f_vergi_no" value="<?=htmlspecialchars($musteri_bilgi['vergi_no'] ?? '')?>">
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 mt-3">
                                    <label class="form-label text-muted small">Fatura Açık Adresi</label>
                                    <textarea class="form-control bg-white" name="fatura_adres" id="f_fatura_adres" rows="2"><?=htmlspecialchars($fatura_bilgi['adres'] ?? '')?></textarea>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mt-3">
                                    <label class="form-label text-muted small">Teslimat Açık Adresi</label>
                                    <textarea class="form-control bg-white" name="teslimat_adres" id="f_teslimat_adres" rows="2"><?=htmlspecialchars($teslimat_bilgi['adres'] ?? '')?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-12">
                    <div class="card custom-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <div class="card-title fw-bold"><i class="bi bi-cart-plus"></i> Sipariş Edilen Ürünler</div>
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
                                        <?php if(!empty($kayitli_urunler)): 
                                            foreach($kayitli_urunler as $ku): 
                                                $kdv_orani_val = $ku['kdv'] ?? 20;
                                                $satir_kdv_haric = (isset($ku['kdv_durumu']) && $ku['kdv_durumu'] == 'Hariç') ? ($ku['fiyat'] * $ku['adet']) : ($ku['satir_toplam'] / (1 + ($kdv_orani_val / 100)));
                                                $satir_kdv_tutari = $ku['satir_toplam'] - $satir_kdv_haric;
                                            ?>
                                                <tr class="sepet-satir" data-aratope="<?=$satir_kdv_haric?>" data-kdvtope="<?=$satir_kdv_tutari?>">
                                                    <input type="hidden" name="urun_id[<?=$ku['id']?>]" value="<?=$ku['id']?>">
                                                    
                                                    <td>
                                                        <select class="form-select data-trigger urun-select" name="urun_id_sec[]" id="choices-single-default" disabled required>
                                                            <option value="">-- Ürün Seçiniz --</option>
                                                            <?php foreach($urunler as $u): 
                                                                $fiyat = ($u['urun_indirim'] > 0) ? $u['urun_indirim'] : $u['urun_fiyat'];
                                                                $sec = ($u['urun_id'] == $ku['id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?=$u['urun_id']?>" data-fiyat="<?=$fiyat?>" data-kdv="<?=$u['urun_kdv']?>" <?=$sec?>>
                                                                    [<?=$u['stok_kodu']?>] <?=$u['urun_adi']?> (<?=$fiyat?> ₺)
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-center text-muted birim-fiyat-txt"><?=number_format($ku['fiyat'], 2, ',', '.')?> ₺</td>
                                                    <td>
                                                        <select class="form-select form-select-sm kdv-durum-select" name="kdv_durum[<?=$ku['id']?>]">
                                                            <option value="2" <?=(isset($ku['kdv_durumu']) && $ku['kdv_durumu'] == 'Dahil' ? 'selected' : '')?>>Dahil</option>
                                                            <option value="1" <?=(isset($ku['kdv_durumu']) && $ku['kdv_durumu'] == 'Hariç' ? 'selected' : '')?>>Hariç (+KDV)</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm text-center miktar-input" name="miktar[<?=$ku['id']?>]" value="<?=$ku['adet']?>" min="1" required>
                                                    </td>
                                                    <td class="text-end fw-bold text-dark satir-toplam-txt"><?=number_format($ku['satir_toplam'], 2, ',', '.')?> ₺</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger satir-sil-btn"><i class="bi bi-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="bosSepetUyarisi" class="p-4 text-center text-muted" style="display: <?=empty($kayitli_urunler)?'block':'none'?>;">
                                <i class="bi bi-bag-x fs-1 opacity-50 mb-2 d-block"></i>
                                Siparişte henüz ürün yok.
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
                                        <input type="number" step="0.01" class="form-control text-end finans-input" name="kargo_ucreti" id="kargo_ucreti" value="<?=$siparis['kargo_ucreti']?>">
                                        <button class="btn btn-outline-secondary" type="button" id="kargoOtoBtn" title="Otomatik Hesaplamaya Dön"><i class="bi bi-arrow-repeat"></i></button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small">Manuel İndirim (₺)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm text-end finans-input" name="indirim_toplam" id="indirim_toplam" value="<?=$siparis['indirim_toplam']?>">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ürünler Ara Toplam:</span>
                                <span class="fw-semibold" id="ozetAraToplam"><?=number_format($siparis['ara_toplam'], 2, ',', '.')?> ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">KDV Toplamı:</span>
                                <span class="fw-semibold" id="ozetKdvToplam"><?=number_format($siparis['kdv_toplam'], 2, ',', '.')?> ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 text-primary">
                                <span class="text-muted">Kargo & İndirim Etkisi:</span>
                                <span class="fw-semibold" id="ozetKargoIndirim">0,00 ₺</span>
                            </div>
                            
                            <div class="p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-15 text-dark">Genel Toplam:</span>
                                <span class="fw-bold fs-20 text-success" id="ozetGenelToplam"><?=number_format($siparis['genel_toplam'], 2, ',', '.')?> ₺</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">Sipariş Durumu</label>
                                <select class="form-select" name="siparis_durumu" id="siparis_durumu_select">
                                    <option value="8" <?=($siparis['siparis_durumu']=='8'?'selected':'')?>>Yeni Sipariş (Onay Bekliyor)</option>
                                    <option value="1" <?=($siparis['siparis_durumu']=='1'?'selected':'')?>>Hazırlanıyor</option>
                                    <option value="2" <?=($siparis['siparis_durumu']=='2'?'selected':'')?>>Kargoya Verildi</option>
                                    <option value="3" <?=($siparis['siparis_durumu']=='3'?'selected':'')?>>Teslim Edildi</option>
                                    <option value="4" <?=($siparis['siparis_durumu']=='4'?'selected':'')?>>İptal Edildi</option>
                                </select>
                            </div>

                            <div id="kargo_bilgileri_alani" style="display: <?=($siparis['siparis_durumu'] == '2' ? 'block' : 'none')?>;">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Kargo Firması</label>
                                    <select class="form-select" name="kargo_firmasi">
                                        <option value="">Kargo Firması Seçin</option>
                                        <option value="Yurtiçi Kargo" <?=($siparis['kargo_firmasi']=='Yurtiçi Kargo'?'selected':'')?>>Yurtiçi Kargo</option>
                                        <option value="Sürat Kargo" <?=($siparis['kargo_firmasi']=='Sürat Kargo'?'selected':'')?>>Sürat Kargo</option>
                                        <option value="Aras Kargo" <?=($siparis['kargo_firmasi']=='Aras Kargo'?'selected':'')?>>Aras Kargo</option>
                                        <option value="MNG Kargo" <?=($siparis['kargo_firmasi']=='MNG Kargo'?'selected':'')?>>MNG Kargo</option>
                                        <option value="PTT Kargo" <?=($siparis['kargo_firmasi']=='PTT Kargo'?'selected':'')?>>PTT Kargo</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small">Kargo Takip Numarası</label>
                                    <input type="text" class="form-control" name="kargo_takip_no" value="<?=$siparis['kargo_takip_no'] ?? ''?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small">Ödeme Durumu</label>
                                <select class="form-select" name="odeme_durumu">
                                    <option value="0" <?=($siparis['odeme_durumu']==0?'selected':'')?>>Ödeme Bekliyor</option>
                                    <option value="1" <?=($siparis['odeme_durumu']==1?'selected':'')?>>Ödeme Alındı (Ödendi)</option>
                                </select>
                            </div>

                            <div class="p-3 border border-warning rounded bg-light mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="musteriye_mail_at" value="1" id="mail_gonder" checked>
                                    <label class="form-check-label fw-bold ms-2 text-dark" for="mail_gonder" style="font-size:12px;">Müşteriye Güncelleme Maili Gönder</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">Yönetici Notu</label>
                                <textarea class="form-control" name="admin_notu" rows="2"><?=htmlspecialchars($siparis['admin_notu'] ?? '')?></textarea>
                            </div>
                            <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 fs-14 shadow-sm me-2">
                                    <i class="bi bi-check-circle-fill me-2"></i> Kaydet
                                </button>
                                <?php if ($siparis['odeme_durumu'] == 0): ?>
                                    <a href="odeme/?kod=<?=$siparis['siparis_kodu']?>" class="btn btn-warning w-100 py-3 fs-14 shadow-sm">
                                        <i class="bi bi-check-circle-fill me-2"></i> Online Ödeme Yap
                                    </a>
                                <?php endif ?>
                            </div>
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