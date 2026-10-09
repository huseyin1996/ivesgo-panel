<?php 
if (!modulAktifMi($db, 'menu') && !yetkisiVarMi("menuler", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$menu_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_menuler WHERE menu_id = :menu_id");
$sor->execute(["menu_id" => $menu_id]);

if($sor->rowCount() > 0){
    $menu = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."menuler/");
    exit;
}

$anaMenuler = $db->query("SELECT * FROM i_menuler WHERE ust_id = 0 AND menu_id != {$menu_id} ORDER BY sira ASC")->fetchAll(PDO::FETCH_ASSOC);

$sabitSayfalar = [
    'index/'              => 'Ana Sayfa (Index)',
    'urunler/'            => 'Ürünler',
    'blog/'               => 'Blog Liste',
    'cozumler/'           => 'Çözümler',
    'hizmetler/'          => 'Hizmetler',
    'musteri-yorumlari/'  => 'Müşteri Yorumları',
    'galeri/'             => 'Galeri',
    'referanslar/'        => 'Referanslar',
    'sertifikalar/'       => 'Sertifikalar',
    'video-galeri/'       => 'Video Galeri',
    'sozlesme/'           => 'Sözleşme',
    'sss/'                => 'Sıkça Sorulan Sorular (SSS)',
    'tarihce/'            => 'Tarihçe',
    'teklif-al/'          => 'Teklif Al',
    'iletisim/'           => 'İletişim',
    'projeler/'           => 'Projeler',
    'proje'              => 'Proje Detay',
    'ekibimiz/'           => 'Ekibimiz',
    'bakim/'              => 'Bakım Modu',
    '404/'                => '404 Sayfası'
];
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Menü Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="menuler/">Menüler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menü Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold"><b><?=htmlspecialchars($menu['menu_baslik'])?></b> Menüsü Düzenleniyor</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($menu['guncelleme_tarihi']) ? tarihSaat($menu['guncelleme_tarihi']) : tarihSaat($menu['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/menus" method="post">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$menu['menu_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12 p-3 bg-light border rounded mb-2">
                                    <label class="form-label fw-bold text-primary"><i class="bi bi-magic"></i> Hızlı Bağlantı Sihirbazı (Otomatik URL ve Başlık Güncelle)</label>
                                    <div class="row g-2">
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliSabit">
                                                <option value="">-- Sabit Sistem Sayfası Seç --</option>
                                                <?php foreach($sabitSayfalar as $urlKey => $urlAdi): ?>
                                                    <option value="<?=$urlKey?>"><?=$urlAdi?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliSayfa">
                                                <option value="">-- Kurumsal / Hizmet Seç --</option>
                                                <?php 
                                                $kurumsalSayfalar = $db->query("SELECT sayfa_baslik, sayfa_url FROM i_sayfalar WHERE sayfa_durum = 1")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($kurumsalSayfalar as $kSayfa): 
                                                ?>
                                                    <option value="<?=$kSayfa['sayfa_url']?>/"><?=$kSayfa['sayfa_baslik']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliKategori">
                                                <option value="">-- Ürün Kategorisi Seç --</option>
                                                <?php 
                                                $kategoriler = $db->query("SELECT kategori_adi, kategori_url FROM i_kategoriler WHERE durum = 1")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($kategoriler as $kat): 
                                                ?>
                                                    <option value="urunler/<?=$kat['kategori_url']?>/"><?=$kat['kategori_adi']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliUrun">
                                                <option value="">-- Ürün Seç --</option>
                                                <?php 
                                                $urunler = $db->query("SELECT urun_adi, urun_url FROM i_urunler WHERE durum = 1")->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($urunler as $urn): 
                                                ?>
                                                    <option value="urun/<?=$urn['urun_url']?>/"><?=$urn['urun_adi']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Menü Tipi</label>
                                    <select class="form-select" name="menu_tip">
                                        <option value="0" <?=($menu['menu_tip']==0?'selected':'')?>>Header Menü</option>
                                        <option value="1" <?=($menu['menu_tip']==1?'selected':'')?>>Footer Menü</option>
                                        <option value="2" <?=($menu['menu_tip']==2?'selected':'')?>>Mega Menü</option>
                                        <option value="3" <?=($menu['menu_tip']==3?'selected':'')?>>Top Menü</option>
                                    </select>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Üst Menü (Parent)</label>
                                    <select class="form-select" name="ust_id">
                                        <option value="0">Ana Menü Olsun</option>
                                        <?php foreach($anaMenuler as $ust): ?>
                                            <option value="<?=$ust['menu_id']?>" <?=($menu['ust_id']==$ust['menu_id']?'selected':'')?>><?=$ust['menu_baslik']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Menü Etiket (Badge)</label>
                                    <input type="text" class="form-control" name="menu_etiket" placeholder="Örn: Yeni, Hot" value="<?=$menu['menu_etiket']?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Menü Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_baslik" id="menuBaslik" placeholder="Örn: Hakkımızda" required value="<?=$menu['menu_baslik']?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">URL / Bağlantı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_url" id="menuUrl" placeholder="Örn: hakkimizda veya https://..." required value="<?=$menu['menu_url']?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">İkon (Tek/Çift tırnak destekli HTML veya Class)</label>
                                    <input type="text" class="form-control" name="menu_icon" placeholder='Örn: <i class="bi bi-house"></i> veya bi bi-house' value="<?=$menu['menu_icon']?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Hedef Sekme (Target)</label>
                                    <select class="form-select" name="menu_hedef">
                                        <option value="_self" <?=($menu['menu_hedef']=='_self'?'selected':'')?>>Aynı Sekmede Aç (_self)</option>
                                        <option value="_blank" <?=($menu['menu_hedef']=='_blank'?'selected':'')?>>Yeni Sekmede Aç (_blank)</option>
                                    </select>
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