<?php 
if (!modulAktifMi($db, 'sabit-sayfa') && !yetkisiVarMi("sabit-sayfa", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sabit Sayfa Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sabit-sayfalar/">Sabit Sayfalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sabit Sayfa Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Sabit Sayfa Ekle</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/statics" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="baslik" class="form-label">Sayfa Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="baslik" name="baslik" placeholder="Örn: İletişim, Hakkımızda vb." required>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="sayfa_url" class="form-label">Sayfa URL / Key</label>
                                    <input type="text" class="form-control" id="sayfa_url" name="sayfa_url" placeholder="Boş bırakılırsa başlıktan üretilir">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="SEO Title giriniz">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="sayfa_resim" class="form-label">Sayfa Resmi (Background / OG Image)</label>
                                    <input class="form-control py-1" type="file" id="sayfa_resim" name="sayfa_resim" accept="image/*">
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="SEO Description giriniz"></textarea>
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