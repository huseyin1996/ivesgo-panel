<?php 
if (!modulAktifMi($db, 'sabit-resim') && !yetkisiVarMi("sabit-resim", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sabit Resim Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sabit-resimler/">Sabit Resimler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sabit Resim Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Sabit Resim Ekle</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/staticimages" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="resim_baslik" class="form-label">Resim Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="resim_baslik" name="resim_baslik" placeholder="Örn: Site Logosu, Footer Logo vb." required>
                                    <small class="text-muted">Bu başlıktan otomatik olarak sistem anahtarı (resim_adi) üretilir.</small>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="resim" class="form-label">Resim Dosyası <span class="text-danger">*</span></label>
                                    <input class="form-control py-1" type="file" id="resim" name="resim" accept="image/*" required>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Bilgileri Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>