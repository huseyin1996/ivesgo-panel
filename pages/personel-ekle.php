<?php 
if (!yetkisiVarMi("personeller", 'ekle')) {
    header("Location:" . URL . "index");
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Personel Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="personeller/">Personeller</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personel Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Personel Bilgileri</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/users" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="uye_ad_soyad" placeholder="Örn: Ahmet Yılmaz" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kullanıcı Adı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="uye_kullanici_adi" placeholder="Örn: ahmetyilmaz" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Şifre <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="uye_sifre" placeholder="Güçlü bir şifre girin" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">E-Posta Adresi</label>
                                    <input type="email" class="form-control" name="uye_eposta" placeholder="ahmet@sirket.com">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Telefon Numarası</label>
                                    <input type="text" class="form-control" name="uye_telefon" placeholder="0555 ...">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Yetki / Rütbe</label>
                                    <select class="form-select" name="uye_rutbe">
                                        <option value="1">Süper Admin</option>
                                        <option value="2">Yönetici</option>
                                        <option value="3">Personel</option>
                                    </select>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Profil Resmi</label>
                                    <input type="file" class="form-control" name="uye_resim" accept="image/*">
                                </div>

                                <div class="col-xl-6 d-flex align-items-center gap-4 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="uye_onay" value="1" id="onaySwitch" checked>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="onaySwitch">Hesap Aktif</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="uye_bildirim" value="1" id="bildirimSwitch" checked>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="bildirimSwitch">Bildirimler Açık</label>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4">
                                    <hr>
                                    <h5 class="fw-bold mb-3">Modül Yetkilendirme Matrisi</h5>
                                    <p class="text-muted fs-13">Personele özel modül bazlı görüntüleme, ekleme, düzenleme ve silme kısıtlamaları tanımlayın.</p>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start">Modül Adı</th>
                                                    <th>
                                                        <div class="form-check d-flex justify-content-center align-items-center gap-1 mb-0">
                                                            <input class="form-check-input select-all-column" type="checkbox" data-target="goruntule" id="all_gor">
                                                            <label class="form-check-label fw-bold cursor-pointer mb-0" for="all_gor">Görüntüle</label>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="form-check d-flex justify-content-center align-items-center gap-1 mb-0">
                                                            <input class="form-check-input select-all-column" type="checkbox" data-target="ekle" id="all_ekl">
                                                            <label class="form-check-label fw-bold cursor-pointer mb-0" for="all_ekl">Ekle</label>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="form-check d-flex justify-content-center align-items-center gap-1 mb-0">
                                                            <input class="form-check-input select-all-column" type="checkbox" data-target="duzenle" id="all_duz">
                                                            <label class="form-check-label fw-bold cursor-pointer mb-0" for="all_duz">Düzenle</label>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="form-check d-flex justify-content-center align-items-center gap-1 mb-0">
                                                            <input class="form-check-input select-all-column" type="checkbox" data-target="durum" id="all_dur">
                                                            <label class="form-check-label fw-bold cursor-pointer mb-0" for="all_dur">Durum</label>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="form-check d-flex justify-content-center align-items-center gap-1 mb-0">
                                                            <input class="form-check-input select-all-column" type="checkbox" data-target="sil" id="all_sil">
                                                            <label class="form-check-label fw-bold cursor-pointer mb-0" for="all_sil">Sil</label>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $moduller = [
                                                    'siparisler'        => 'Siparişler ve Satış',
                                                    'markalar'          => 'Markalar',
                                                    'kampanyalar'       => 'Kampanyalar',
                                                    'raporlar'          => 'Raporlar ve İstatistikler',
                                                    'ziyaretler'        => 'Müşteri Ziyaretleri',
                                                    'personeller'       => 'Personel Yönetimi',
                                                    'urunler'           => 'Ürün Yönetimi',
                                                    'kategoriler'       => 'Kategori Yönetimi',
                                                    'blog'              => 'Blog Yönetimi',
                                                    'sayfalar'          => 'Sayfa Yönetimi',
                                                    'menuler'           => 'Menü Yönetimi',
                                                    'musteri-yorumlari' => 'Yorum Yönetimi',
                                                    'galeri'            => 'Galeri Yönetimi',
                                                    'slider'            => 'Slider Yönetimi',
                                                    'sss'               => 'SSS Yönetimi',
                                                    'tarihce'           => 'Tarihçe Yönetimi',
                                                    'iletisim'          => 'İletişim Yönetimi',
                                                    'ekibimiz'          => 'Ekip Yönetimi',
                                                    'bakim'             => 'Bakım Modu Yönetimi',
                                                    'seo-sayfa'         => 'Sayfa Seo Yönetimi',
                                                    'sabit-resim'       => 'Sabit Resim Yönetimi',
                                                    'mail'              => 'Mail Hesap Yönetimi',
                                                    'logs'              => 'Sistem Logları',
                                                    'ayarlar'           => 'Sistem Ayarları'
                                                ];

                                                foreach($moduller as $modulKey => $modulAdi):?>
                                                <tr>
                                                    <td class="text-start fw-semibold"><?=$modulAdi?></td>
                                                    <td>
                                                        <input class="form-check-input" type="checkbox" name="izinler[<?=$modulKey?>][goruntule]" value="1">
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input" type="checkbox" name="izinler[<?=$modulKey?>][ekle]" value="1">
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input" type="checkbox" name="izinler[<?=$modulKey?>][duzenle]" value="1">
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input" type="checkbox" name="izinler[<?=$modulKey?>][sil]" value="1">
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Personeli Kaydet
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