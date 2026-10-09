<?php
if (!yetkisiVarMi("personeller", 'duzenle')) {
    header("Location:" . URL . "index");
}
$sor = $db->prepare("SELECT * FROM i_uyeler WHERE uye_id = :uye_id");
$sor->execute(["uye_id" => $par[1]]);
if($sor->rowCount() > 0){
    $uye = $sor->fetch(PDO::FETCH_ASSOC);
    $mevcutIzinler = !empty($uye['izinler']) ? json_decode($uye['izinler'], true) : [];
} else {
    header("Location:".URL."personeller/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Personel Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="personeller/">Personeller</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personel Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Personel Bilgilerini ve Yetkilerini Güncelle</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/users" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$uye['uye_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="uye_ad_soyad" value="<?=htmlspecialchars($uye['uye_ad_soyad'])?>" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kullanıcı Adı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="uye_kullanici_adi" value="<?=htmlspecialchars($uye['uye_kullanici_adi'])?>" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Yeni Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                                    <input type="password" class="form-control" name="uye_sifre" placeholder="Boş bırakılırsa eskisi kalır">
                                    <small class="text-muted">Güvenlik gereği son 3 şifrenizden birini tekrar giremezsiniz.</small>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">E-Posta Adresi</label>
                                    <input type="email" class="form-control" name="uye_eposta" value="<?=htmlspecialchars($uye['uye_eposta'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Telefon Numarası</label>
                                    <input type="text" class="form-control" name="uye_telefon" value="<?=htmlspecialchars($uye['uye_telefon'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Yetki / Rütbe</label>
                                    <select class="form-select" name="uye_rutbe">
                                        <option value="1" <?=($uye['uye_rutbe']==1 ?'selected' : '')?>>Süper Admin (Tam Yetkili)</option>
                                        <option value="2" <?=($uye['uye_rutbe']==2 ?'selected' : '')?>>Yönetici</option>
                                        <option value="3" <?=($uye['uye_rutbe']==3 ?'selected' : '')?>>Personel</option>
                                    </select>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Profil Resmi</label>
                                    <input type="file" class="form-control" name="uye_resim" accept="image/*">
                                    <?php if(!empty($uye['uye_resim'])): ?>
                                        <div class="mt-2"><img src="assets/images/users/<?=$uye['uye_resim']?>" width="50" height="50" class="rounded-circle shadow-sm" style="object-fit:cover;"></div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-xl-6 d-flex align-items-center gap-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="uye_onay" value="1" id="onaySwitch" <?=($uye['uye_onay']==1?'checked':'')?>>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="onaySwitch">Hesap Aktif</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="uye_bildirim" value="1" id="bildirimSwitch" <?=($uye['uye_bildirim']==1?'checked':'')?>>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="bildirimSwitch">Bildirimler Açık</label>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4">
                                    <hr>
                                    <h5 class="fw-bold mb-3">Modül Yetkilendirme Matrisi</h5>
                                    <p class="text-muted fs-13">Personele özel modül bazlı görüntüleme, ekleme, düzenleme, durum ve silme kısıtlamaları tanımlayın.</p>
                                    
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

                                                foreach($moduller as$modulKey => $modulAdi):$gor = $mevcutIzinler[$modulKey]['goruntule'] ?? 0;
                                                    $ekl = $mevcutIzinler[$modulKey]['ekle'] ?? 0;
                                                    $duz = $mevcutIzinler[$modulKey]['duzenle'] ?? 0;
                                                    $dur = $mevcutIzinler[$modulKey]['durum'] ?? 0;
                                                    $sil = $mevcutIzinler[$modulKey]['sil'] ?? ($mevcutIzinler[$modulKey]['sil'] ?? 0);
                                                ?>
                                                <tr>
                                                    <td class="text-start fw-semibold"><?=$modulAdi?></td>
                                                    <td>
                                                        <input class="form-check-input permission-checkbox" data-permission="goruntule" type="checkbox" name="izinler[<?=$modulKey?>][goruntule]" value="1" <?=($gor == 1 ? 'checked' : '')?>>
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input permission-checkbox" data-permission="ekle" type="checkbox" name="izinler[<?=$modulKey?>][ekle]" value="1" <?=($ekl == 1 ? 'checked' : '')?>>
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input permission-checkbox" data-permission="duzenle" type="checkbox" name="izinler[<?=$modulKey?>][duzenle]" value="1" <?=($duz == 1 ? 'checked' : '')?>>
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input permission-checkbox" data-permission="durum" type="checkbox" name="izinler[<?=$modulKey?>][durum]" value="1" <?=($dur == 1 ? 'checked' : '')?>>
                                                    </td>
                                                    <td>
                                                        <input class="form-check-input permission-checkbox" data-permission="sil" type="checkbox" name="izinler[<?=$modulKey?>][sil]" value="1" <?=($sil == 1 ? 'checked' : '')?>>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Değişiklikleri Kaydet
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