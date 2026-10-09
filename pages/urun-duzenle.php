<?php
if (!modulAktifMi($db, 'urunler') && !yetkisiVarMi("urunler", 'duzenle')) {
    header("Location:" . URL . "index");
}
$sor = $db->prepare("SELECT * FROM i_urunler WHERE urun_id=:urun_id");
$sor->execute(array("urun_id" => $par[1]));
if($sor->rowCount() > 0){
    $cek = $sor->fetch(PDO::FETCH_ASSOC);
}else{
    header("Location:../urunler/");
    exit;
}

$galeri_sorgu = $db->prepare("SELECT id, resim FROM i_urun_resimler WHERE urun_id = :id ORDER BY sira ASC, id ASC");
$galeri_sorgu->execute(['id' => $cek['urun_id']]);
$galeri_resimleri = $galeri_sorgu->fetchAll(PDO::FETCH_ASSOC);

$kategori_sorgu = $db->query("SELECT id, ust_id, kategori_adi FROM i_kategoriler ORDER BY sira ASC, kategori_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
$kategori_agaci = [];
foreach ($kategori_sorgu as $kategori) {
    $kategori_agaci[$kategori['ust_id']][] = $kategori;
}

if (!function_exists('kategori_secenekleri_olustur')) {
    function kategori_secenekleri_olustur($agac, $ust_id = 0, $derinlik = 0, $secili_id = null, $duzenlenen_id = null) {
        if (isset($agac[$ust_id])) {
            foreach ($agac[$ust_id] as $kat) {
                if ($duzenlenen_id == $kat['id']) continue; 
                $girinti = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $derinlik) . ($derinlik > 0 ? "↳ " : "");
                $secili = ($secili_id == $kat['id']) ? 'selected' : '';
                echo '<option value="' . $kat['id'] . '" ' . $secili . '>' . $girinti . htmlspecialchars($kat['kategori_adi']) . '</option>';
                kategori_secenekleri_olustur($agac, $kat['id'], $derinlik + 1, $secili_id, $duzenlenen_id);
            }
        }
    }
}

$markalar = $db->query("SELECT id, marka_adi FROM i_markalar ORDER BY marka_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Ürünler - Hizmetler</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Ürünler - Hizmetler</a></li>
                <li class="breadcrumb-item"><a href="urunler/">Tüm Ürünler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ürün - Hizmet Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Ürün - Hizmet Düzenle
                        </div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <form class="postForm needs-validation" action="request/products" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['urun_id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <ul class="nav nav-tabs mb-4 border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-bold px-4" id="temel-tab" data-bs-toggle="tab" data-bs-target="#temel-pane" type="button" role="tab">
                                        <i class="bi bi-box-seam me-2"></i> Temel & Fiyat
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="icerik-tab" data-bs-toggle="tab" data-bs-target="#icerik-pane" type="button" role="tab">
                                        <i class="bi bi-card-text me-2"></i> İçerik & SEO
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="medya-tab" data-bs-toggle="tab" data-bs-target="#medya-pane" type="button" role="tab">
                                        <i class="bi bi-images me-2"></i> Görseller & Galeri
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content">
                                
                                <div class="tab-pane fade p-0 border-0 show active" id="temel-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="stok_kodu" class="form-label">Stok Kodu <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white" id="stok_kodu" name="stok_kodu" value="<?=$cek['stok_kodu']?>" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="urun_adi" class="form-label">Ürün / Hizmet Adı <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white" id="urun_adi" name="urun_adi" value="<?=$cek['urun_adi']?>" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="urun_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select bg-white choices-select" name="urun_kategori" id="urun_kategori" required>
                                                <option value="">Kategori Seçiniz</option>
                                                <?php kategori_secenekleri_olustur($kategori_agaci, 0, 0, $cek['urun_kategori'], null); ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="marka_id" class="form-label">Marka</label>
                                            <select class="form-select bg-white choices-select" name="marka_id" id="marka_id">
                                                <option value="0">Marka Yok</option>
                                                <?php foreach($markalar as $marka): ?>
                                                    <option value="<?= $marka['id'] ?>" <?=($cek['marka_id'] == $marka['id'] ? 'selected' : '')?>><?=$marka['marka_adi']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-4"><h6 class="fw-bold mb-0 border-bottom pb-2">Fiyat ve Stok Detayları</h6></div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <label for="alis_fiyati" class="form-label">Alış Fiyatı (Maliyet)</label>
                                            <input type="number" step="0.01" class="form-control bg-white" id="alis_fiyati" name="alis_fiyati" value="<?=$cek['alis_fiyati']?>">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <label for="urun_fiyat" class="form-label">Satış Fiyatı</label>
                                            <input type="number" step="0.01" class="form-control bg-white" id="urun_fiyat" name="urun_fiyat" value="<?=$cek['urun_fiyat']?>">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <label for="urun_indirim" class="form-label">İndirimli Fiyat</label>
                                            <input type="number" step="0.01" class="form-control bg-white" id="urun_indirim" name="urun_indirim" value="<?=$cek['urun_indirim']?>">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <label for="para_birimi" class="form-label">Para Birimi</label>
                                            <select class="form-select bg-white" name="para_birimi" id="para_birimi">
                                                <option value="TRY" <?=($cek['para_birimi'] == "TRY" ? 'selected' : '')?>>TL (₺)</option>
                                                <option value="USD" <?=($cek['para_birimi'] == "USD" ? 'selected' : '')?>>Dolar ($)</option>
                                                <option value="EUR" <?=($cek['para_birimi'] == "EUR" ? 'selected' : '')?>>Euro (€)</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label for="urun_kdv" class="form-label">KDV Oranı (%)</label>
                                            <input type="number" step="0.01" class="form-control bg-white" id="urun_kdv" name="urun_kdv" value="<?=$cek['urun_kdv']?>">
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label for="urun_stok" class="form-label">Stok Miktarı</label>
                                            <input type="number" class="form-control bg-white" id="urun_stok" name="urun_stok" value="<?=$cek['urun_stok']?>">
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <label for="stok_birimi" class="form-label">Stok Birimi</label>
                                            <select class="form-select bg-white" name="stok_birimi" id="stok_birimi">
                                                <option value="Adet" <?=($cek['stok_birimi'] == "Adet" ? 'selected' : '')?>>Adet</option>
                                                <option value="Kg" <?=($cek['stok_birimi'] == "Kg" ? 'selected' : '')?>>Kilogram (Kg)</option>
                                                <option value="Metre" <?=($cek['stok_birimi'] == "Metre" ? 'selected' : '')?>>Metre</option>
                                                <option value="Kutu" <?=($cek['stok_birimi'] == "Kutu" ? 'selected' : '')?>>Kutu</option>
                                                <option value="Paket" <?=($cek['stok_birimi'] == "Paket" ? 'selected' : '')?>>Paket</option>
                                                <option value="Hizmet" <?=($cek['stok_birimi'] == "Hizmet" ? 'selected' : '')?>>Hizmet</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0 border-0" id="medya-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="p-3 border rounded bg-white">
                                                <label for="kapak_resmi" class="form-label fw-bold"><i class="bi bi-image"></i> Ana Kapak Resmi (Vitrin)</label>
                                                <input class="form-control form-control-sm py-0 ps-2" type="file" id="kapak_resmi" name="kapak_resmi" accept="image/*">
                                                
                                                <?php if (!empty($cek['kapak_resmi'])): ?>
                                                    <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                                        <img src="assets/images/urunler/thumb/<?= htmlspecialchars($cek['kapak_resmi']) ?>" 
                                                             alt="Kapak Görseli" class="img-thumbnail me-3 shadow-sm" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                            <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                                Mevcut Kapağı Sil
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="p-3 border rounded bg-white">
                                                <label for="galeri" class="form-label fw-bold"><i class="bi bi-images"></i> Galeriye Yeni Resimler Ekle</label>
                                                <input class="form-control form-control-sm py-0 ps-2 mb-3" type="file" id="galeri" name="galeri[]" multiple accept="image/*">
                                                
                                                <?php if ($galeri_resimleri): ?>
                                                <div class="mt-2">
                                                    <label class="form-label fw-bold mb-2 text-dark"><i class="bi bi-grid"></i> Mevcut Galeri Resimleri (Sürükleyerek Sıralayın)</label>
                                                    <div class="p-3 border rounded bg-light" style="max-height: 400px; overflow-y: auto;">
                                                        
                                                        <div id="sortable-gallery" class="row gy-3">
                                                            <?php foreach($galeri_resimleri as $gresim): ?>
                                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 text-center">
                                                                    <div class="card shadow-sm border h-100 position-relative cursor-move bg-white">
                                                                        
                                                                        <input type="hidden" name="galeri_sira[]" value="<?= $gresim['id'] ?>">

                                                                        <div class="card-header p-1 border-bottom bg-light text-muted" style="cursor: grab;">
                                                                            <i class="bi bi-arrows-move"></i> Sürükle
                                                                        </div>
                                                                        <div class="card-body p-2">
                                                                            <img src="assets/images/urunler/thumb/<?= htmlspecialchars($gresim['resim']) ?>" 
                                                                                 alt="Galeri" class="rounded border mb-2 w-100" style="height: 100px; object-fit: cover;">
                                                                            
                                                                            <div class="form-check text-start mb-1">
                                                                                <input class="form-check-input" type="checkbox" name="galeri_sil[]" value="<?= $gresim['id'] ?>" id="gsil_<?= $gresim['id'] ?>">
                                                                                <label class="form-check-label text-danger" style="font-size:12px;" for="gsil_<?= $gresim['id'] ?>">Sil</label>
                                                                            </div>
                                                                            
                                                                            <div class="form-check text-start">
                                                                                <input class="form-check-input" type="radio" name="kapak_yap" value="<?= $gresim['id'] ?>" id="gkapak_<?= $gresim['id'] ?>">
                                                                                <label class="form-check-label text-primary" style="font-size:12px;" for="gkapak_<?= $gresim['id'] ?>">Kapak Yap</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0 border-0" id="icerik-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <label for="kisa_aciklama" class="form-label">Kısa Açıklama (Liste sayfalarında görünür)</label>
                                            <textarea class="form-control bg-white" id="kisa_aciklama" name="kisa_aciklama" rows="3" maxlength="255"><?=$cek['kisa_aciklama']?></textarea>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <label for="urun_aciklama" class="form-label">Detaylı Ürün Açıklaması</label>
                                            <textarea class="form-control bg-white ckeditor-init" id="urun_aciklama" name="urun_aciklama"><?=$cek['urun_aciklama']?></textarea>
                                        </div>

                                        <div class="col-12 mt-4"><h6 class="fw-bold mb-0 border-bottom pb-2">SEO & Görünürlük Ayarları</h6></div>

                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="seo_title" class="form-label">SEO Başlığı</label>
                                            <input type="text" class="form-control bg-white" id="seo_title" name="seo_title" value="<?=$cek['seo_title']?>">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="seo_description" class="form-label">SEO Açıklaması</label>
                                            <input type="text" class="form-control bg-white" id="seo_description" name="seo_description" value="<?=$cek['seo_description']?>">
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input fs-5" type="checkbox" name="durum" <?=($cek['durum'] == 1 ? 'checked' : '')?> value="1" id="durum" role="switch">
                                                <label class="form-check-label fs-14 mt-1 ms-2" for="durum">Ürün Yayında (Aktif)</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input fs-5" type="checkbox" name="vitrin" <?=($cek['vitrin'] == 1 ? 'checked' : '')?> value="1" id="vitrin" role="switch">
                                                <label class="form-check-label fs-14 mt-1 ms-2" for="vitrin">Anasayfa Vitrininde Göster</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input fs-5" type="checkbox" name="yeni_urun" <?=($cek['yeni_urun'] == 1 ? 'checked' : '')?> value="1" id="yeni_urun" role="switch">
                                                <label class="form-check-label fs-14 mt-1 ms-2" for="yeni_urun">"Yeni" Etiketi Ekle</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 fs-15 shadow-sm">
                                        <i class="bi bi-save me-2"></i> Ürünü Güncelle
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var galleryGrid = document.getElementById('sortable-gallery');
        if(galleryGrid) {
            new Sortable(galleryGrid, {
                animation: 150,
                ghostClass: 'bg-light',
                handle: '.card-header',
                onEnd: function (evt) {
                    console.log("Yeni sıralama düzenlendi. Kaydet butonuna basınca uygulanacak.");
                }
            });
        }
    });
</script>