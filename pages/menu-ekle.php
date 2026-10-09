<?php 
if (!modulAktifMi($db, 'menu') && !yetkisiVarMi("menuler", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}

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
    'sss/'                => 'Sıkça Sorulan Sorular (SSS)',
    'tarihce/'            => 'Tarihçe',
    'teklif-al/'          => 'Teklif Al',
    'iletisim/'           => 'İletişim',
    'projeler/'           => 'Projeler',
    'ekibimiz/'           => 'Ekibimiz'
];

$kurumsalSayfalar =$db->query("SELECT sayfa_baslik, sayfa_url FROM i_sayfalar WHERE sayfa_durum = 1")->fetchAll(PDO::FETCH_ASSOC);
$kategoriler      =$db->query("SELECT kategori_adi, kategori_url FROM i_kategoriler WHERE durum = 1")->fetchAll(PDO::FETCH_ASSOC);
$urunler          =$db->query("SELECT urun_adi, urun_url FROM i_urunler WHERE durum = 1")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Gelişmiş Menü Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="menuler/">Menüler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menü Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Menü Yapılandırma ve Hızlı Bağlantı Sihirbazı</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/menus" method="post">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <!-- Hızlı Bağlantı Sihirbazı (Kategoriler ve Ürünler Dahil) -->
                                <div class="col-xl-12 p-3 bg-light border rounded mb-2">
                                    <label class="form-label fw-bold text-primary"><i class="bi bi-magic"></i> Hızlı Bağlantı Sihirbazı (Otomatik URL Doldur)</label>
                                    <div class="row g-2">
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliSabit">
                                                <option value="">-- Sabit Sistem Sayfası Seç --</option>
                                                <?php foreach($sabitSayfalar as $urlKey =>$urlAdi): ?>
                                                    <option value="<?=$urlKey?>"><?=$urlAdi?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliSayfa">
                                                <option value="">-- Kurumsal / Hizmet / Sözleşme Seç --</option>
                                                <?php foreach($kurumsalSayfalar as $kSayfa): ?>
                                                    <option value="<?=$kSayfa['sayfa_url']?>/"><?=$kSayfa['sayfa_baslik']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliKategori">
                                                <option value="">-- Ürün Kategorisi Seç --</option>
                                                <?php foreach($kategoriler as$kat): ?>
                                                    <option value="urunler/<?=$kat['kategori_url']?>/"><?=$kat['kategori_adi']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <select class="form-select form-select-sm" id="hizliUrun">
                                                <option value="">-- Ürün Seç --</option>
                                                <?php foreach($urunler as$urn): ?>
                                                    <option value="urun/<?=$urn['urun_url']?>/"><?=$urn['urun_adi']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Menü Tipi <span class="text-danger">*</span></label>
                                    <select class="form-select" name="menu_tip" id="menu_tip">
                                        <option value="0">Header Menü</option>
                                        <option value="1">Footer Menü</option>
                                        <option value="2">Mega Menü</option>
                                        <option value="3">Top Menü</option>
                                    </select>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Üst Menü (Seçilen tipe göre filtrelenir)</label>
                                    <select class="form-select" name="ust_id" id="menu_ust">
                                        <option value="0">Ana Menü Olsun</option>
                                        <!-- AJAX ile dolacak -->
                                    </select>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Menü Etiket (Badge)</label>
                                    <input type="text" class="form-control" name="menu_etiket" placeholder="Örn: Yeni, Hot">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Menü Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_baslik" id="menuBaslik" placeholder="Örn: Hakkımızda" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">URL / Bağlantı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="menu_url" id="menuUrl" placeholder="Örn: hakkimizda veya https://..." required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">İkon (Tek/Çift tırnak destekli HTML veya Class)</label>
                                    <input type="text" class="form-control" name="menu_icon" placeholder='Örn: <i class="bi bi-house"></i> veya bi bi-house'>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Hedef Sekme (Target)</label>
                                    <select class="form-select" name="menu_hedef">
                                        <option value="_self">Aynı Sekmede Aç (_self)</option>
                                        <option value="_blank">Yeni Sekmede Aç (_blank)</option>
                                    </select>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Menüyü Kaydet
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuUrl = document.getElementById('menuUrl');
    const menuBaslik = document.getElementById('menuBaslik');

    const hizliSabit = document.getElementById('hizliSabit');
    const hizliKategori = document.getElementById('hizliKategori');
    const hizliUrun = document.getElementById('hizliUrun');

    // Hızlı bağlantı yönetimi (Sadece birini aktif tutma)
    if(hizliSabit) {
        hizliSabit.addEventListener('change', function() {
            if(this.value) {
                menuUrl.value = this.value;
                if(!menuBaslik.value) menuBaslik.value = this.options[this.selectedIndex].text;
                if(hizliKategori) hizliKategori.value = "";
                if(hizliUrun) hizliUrun.value = "";
            }
        });
    }

    if(hizliKategori) {
        hizliKategori.addEventListener('change', function() {
            if(this.value) {
                menuUrl.value = this.value;
                if(!menuBaslik.value) menuBaslik.value = this.options[this.selectedIndex].text;
                if(hizliSabit) hizliSabit.value = "";
                if(hizliUrun) hizliUrun.value = "";
            }
        });
    }

    if(hizliUrun) {
        hizliUrun.addEventListener('change', function() {
            if(this.value) {
                menuUrl.value = this.value;
                if(!menuBaslik.value) menuBaslik.value = this.options[this.selectedIndex].text;
                if(hizliSabit) hizliSabit.value = "";
                if(hizliKategori) hizliKategori.value = "";
            }
        });
    }

    // Menü Tipine Göre Üst Menüleri Filtreleme (AJAX)
    const menuTipSelect = document.getElementById('menu_tip');
    const menuUstSelect = document.getElementById('menu_ust');

    function loadUstMenuler(tip, selectedUstId = 0) {
        fetch('request/menus', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'postType=GetUstMenuler&menu_tip=' + tip + '&csrf_token=<?=$_SESSION['csrf_token'] ?? ''?>'
        })
        .then(res => res.json())
        .then(data => {
            let options = '<option value="0">Ana Menü Olsun</option>';
            if(data && Array.isArray(data)) {
                data.forEach(item => {
                    let sel = (item.menu_id == selectedUstId) ? 'selected' : '';
                    options += `<option value="${item.menu_id}" ${sel}>${item.menu_baslik}</option>`;
                });
            }
            menuUstSelect.innerHTML = options;
        });
    }

    menuTipSelect.addEventListener('change', function() {
        loadUstMenuler(this.value, 0);
    });

    // Sayfa ilk yüklendiğinde varsayılan tip (0) için üst menüleri getir
    loadUstMenuler(menuTipSelect.value, 0);
});
</script>