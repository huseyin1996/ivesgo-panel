<?php 
if (!modulAktifMi($db, 'sayfa') && !yetkisiVarMi("slider", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$fotograf_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_fotograflar WHERE fotograf_id = :fotograf_id");
$sor->execute(["fotograf_id" => $fotograf_id]);

if($sor->rowCount() > 0){
    $slider = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."sliderlar/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Slider Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sliderlar/">Sliderlar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Slider Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Slider Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($slider['guncelleme_tarihi']) ? tarihSaat($slider['guncelleme_tarihi']) : tarihSaat($slider['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/slider" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$slider['fotograf_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Slider Büyük Başlık (Slogan)</label>
                                    <input type="text" class="form-control" name="fotograf_baslik" value="<?=htmlspecialchars($slider['fotograf_baslik'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Manşet Görseli Değiştir</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="fotograf_resim" accept="image/*">
                                    <?php if (!empty($slider['fotograf_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/slider/<?=$slider['fotograf_resim']?>" alt="Slider Görseli" class="img-thumbnail me-3 shadow-sm" width="120">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Mevcut Görseli Sil
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Alt Açıklama / Spot Metin</label>
                                    <textarea class="form-control" name="fotograf_aciklama" rows="2"><?=htmlspecialchars($slider['fotograf_aciklama'] ?? '')?></textarea>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Yazısı</label>
                                    <input type="text" class="form-control" name="buton_yazi" value="<?=htmlspecialchars($slider['buton_yazi'] ?? '')?>">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Bağlantısı (URL / Link)</label>
                                    <input type="text" class="form-control" name="buton_url" value="<?=htmlspecialchars($slider['buton_url'] ?? '')?>">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Hedef Sekme</label>
                                    <select class="form-select" name="buton_hedef">
                                        <option value="_self" <?=($slider['buton_hedef']=='_self'?'selected':'')?>>Aynı Sekmede Aç (_self)</option>
                                        <option value="_blank" <?=($slider['buton_hedef']=='_blank'?'selected':'')?>>Yeni Sekmede Aç (_blank)</option>
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