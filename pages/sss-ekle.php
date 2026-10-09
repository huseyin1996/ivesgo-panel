<?php 
if (!modulAktifMi($db, 'sss') && !yetkisiVarMi("sss", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Soru Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sss/">SSS</a></li>
                <li class="breadcrumb-item active" aria-current="page">Soru Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Soru ve Cevap Detayları</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/fqa" method="post">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Soru <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sss_soru" placeholder="Örn: Hizmetlerinizden nasıl yararlanabilirim?" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Cevap <span class="text-danger">*</span></label>
                                    <textarea class="form-control ckeditor-init" name="sss_cevap" rows="6" placeholder="Sorunun detaylı yanıtını yazın..." required></textarea>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Soruyu Kaydet
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