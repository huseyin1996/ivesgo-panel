<?php 
if (!modulAktifMi($db, 'galeri') && !yetkisiVarMi("galeri", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Medya Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="galeri/">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medya Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Medya Bilgileri</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/gallery" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Başlık <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="galeri_baslik" placeholder="Örn: Proje Görseli, Fabrika Videosu" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Medya Tipi</label>
                                    <select class="form-select" name="galeri_tip" id="galeriTipSelect">
                                        <option value="1">Fotoğraf Galeri</option>
                                        <option value="2">Video Galeri</option>
                                        <option value="3">Referans Logo</option>
                                        <option value="4">Sertifika</option>
                                    </select>
                                </div>

                                <div class="col-xl-12" id="videoUrlContainer" style="display: none;">
                                    <label class="form-label fw-bold text-success">Video URL (YouTube / Embed Link)</label>
                                    <input type="text" class="form-control" name="video_url" placeholder="Örn: https://www.youtube.com/watch?v=...">
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kapak / Medya Görseli</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="galeri_resim" accept="image/*">
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Medyayı Kaydet
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
