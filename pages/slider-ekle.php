<?php 
if (!modulAktifMi($db, 'slider') && !yetkisiVarMi("slider", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Slider Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sliderlar/">Sliderlar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Slider Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Slider Görsel ve Metin Alanları</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/slider" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Slider Büyük Başlık (Slogan)</label>
                                    <input type="text" class="form-control" name="fotograf_baslik" placeholder="Örn: Geleceğin Teknolojileri Burada">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Arkaplan / Manşet Görseli <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="fotograf_resim" accept="image/*" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Alt Açıklama / Spot Metin</label>
                                    <textarea class="form-control" name="fotograf_aciklama" rows="2" placeholder="Slider üzerinde görünecek alt açıklama..."></textarea>
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Yazısı</label>
                                    <input type="text" class="form-control" name="buton_yazi" placeholder="Örn: Detaylı Bilgi">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Bağlantısı (URL / Link)</label>
                                    <input type="text" class="form-control" name="buton_url" placeholder="Örn: hizmetler/yazilim">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Buton Hedef Sekme</label>
                                    <select class="form-select" name="buton_hedef">
                                        <option value="_self">Aynı Sekmede Aç (_self)</option>
                                        <option value="_blank">Yeni Sekmede Aç (_blank)</option>
                                    </select>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Sliderı Kaydet
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