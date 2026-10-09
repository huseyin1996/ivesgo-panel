<?php

if (!modulAktifMi($db, 'urunler') && !yetkisiVarMi("urunler", 'ekle')) {
    header("Location:" . URL . "index");
}

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
                <li class="breadcrumb-item active" aria-current="page">Ürün - Hizmet Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Ürün - Hizmet Ekle
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm needs-validation" action="request/products" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                
                                <div class="col-12"><h6 class="fw-bold mb-0 border-bottom pb-2">Temel Bilgiler</h6></div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="stok_kodu" class="form-label">Stok Kodu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stok_kodu" name="stok_kodu" placeholder="Örn: URN-001" required>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="urun_adi" class="form-label">Ürün / Hizmet Adı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="urun_adi" name="urun_adi" placeholder="Ürün adını giriniz" required>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="urun_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select choices-select" name="urun_kategori" id="urun_kategori" required>
                                        <option value="">Kategori Seçiniz</option>
                                        <?php kategori_secenekleri_olustur($kategori_agaci, 0, 0); ?>
                                    </select>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="marka_id" class="form-label">Marka</label>
                                    <select class="form-select choices-select" name="marka_id" id="marka_id">
                                        <option value="0">Marka Yok</option>
                                        <?php foreach($markalar as $marka): ?>
                                            <option value="<?= $marka['id'] ?>"><?= htmlspecialchars($marka['marka_adi']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- FİYAT VE STOK BİLGİLERİ -->
                                <div class="col-12 mt-5"><h6 class="fw-bold mb-0 border-bottom pb-2">Fiyat & Stok Bilgileri</h6></div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <label for="alis_fiyati" class="form-label">Alış Fiyatı (Maliyet)</label>
                                    <input type="number" step="0.01" class="form-control" id="alis_fiyati" name="alis_fiyati" value="0.00">
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <label for="urun_fiyat" class="form-label">Satış Fiyatı</label>
                                    <input type="number" step="0.01" class="form-control" id="urun_fiyat" name="urun_fiyat" value="0.00">
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <label for="urun_indirim" class="form-label">İndirimli Fiyat</label>
                                    <input type="number" step="0.01" class="form-control" id="urun_indirim" name="urun_indirim" value="0.00">
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <label for="para_birimi" class="form-label">Para Birimi</label>
                                    <select class="form-select" name="para_birimi" id="para_birimi">
                                        <option value="TRY">TL (₺)</option>
                                        <option value="USD">Dolar ($)</option>
                                        <option value="EUR">Euro (€)</option>
                                    </select>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                    <label for="urun_kdv" class="form-label">KDV Oranı (%)</label>
                                    <select class="form-select" name="urun_kdv" id="urun_kdv">
                                        <option value="20">%20</option>
                                        <option value="10">%10</option>
                                        <option value="1">%1</option>
                                        <option value="0">KDV Dahil / Yok</option>
                                    </select>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                    <label for="urun_stok" class="form-label">Stok Miktarı</label>
                                    <input type="number" class="form-control" id="urun_stok" name="urun_stok" value="0">
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                    <label for="stok_birimi" class="form-label">Stok Birimi</label>
                                    <select class="form-select" name="stok_birimi" id="stok_birimi">
                                        <option value="Adet">Adet</option>
                                        <option value="Kg">Kilogram (Kg)</option>
                                        <option value="Metre">Metre</option>
                                        <option value="Kutu">Kutu</option>
                                        <option value="Paket">Paket</option>
                                        <option value="Hizmet">Hizmet (Fiziksel Değil)</option>
                                    </select>
                                </div>

                                <div class="col-12 mt-5"><h6 class="fw-bold mb-0 border-bottom pb-2">Görseller & İçerik</h6></div>

                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <label for="kapak_resmi" class="form-label">Kapak Resmi (Vitrin)</label>
                                    <input class="form-control form-control-sm py-0 ps-2" type="file" id="kapak_resmi" name="kapak_resmi" accept="image/*">
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <label for="galeri" class="form-label">Galeri Resimleri (Çoklu Seçim Yapabilirsiniz)</label>
                                    <input class="form-control form-control-sm py-0 ps-2" type="file" id="galeri" name="galeri[]" multiple accept="image/*">
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="kisa_aciklama" class="form-label">Kısa Açıklama (Liste sayfalarında görünür)</label>
                                    <textarea class="form-control" id="kisa_aciklama" name="kisa_aciklama" rows="3" maxlength="255" placeholder="Ürünün özet açıklaması..."></textarea>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="urun_aciklama" class="form-label">Detaylı Ürün Açıklaması</label>
                                    <textarea class="form-control ckeditor-init" id="urun_aciklama" name="urun_aciklama"></textarea>
                                </div>

                                <div class="col-12 mt-5"><h6 class="fw-bold mb-0 border-bottom pb-2">SEO & Sistem Ayarları</h6></div>

                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <label for="seo_title" class="form-label">SEO Başlığı (Boş bırakılırsa ürün adı kullanılır)</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Arama motorları için başlık">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-12">
                                    <label for="seo_description" class="form-label">SEO Açıklaması (Meta Description)</label>
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Arama motorları için açıklama">
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="durum" value="1" id="durum" checked role="switch">
                                        <label class="form-check-label fs-14 mt-1 ms-2" for="durum">Ürün Yayında (Aktif)</label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="vitrin" value="1" id="vitrin" role="switch">
                                        <label class="form-check-label fs-14 mt-1 ms-2" for="vitrin">Anasayfa Vitrininde Göster</label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="yeni_urun" value="1" id="yeni_urun" role="switch">
                                        <label class="form-check-label fs-14 mt-1 ms-2" for="yeni_urun">"Yeni" Etiketi Ekle</label>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fs-15"><i class="bi bi-save me-2"></i> Ürünü Kaydet</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>