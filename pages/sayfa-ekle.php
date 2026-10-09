<?php 
if (!modulAktifMi($db, 'sayfa') && !yetkisiVarMi("sayfalar", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Sayfa Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sayfalar/">Sayfalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sayfa Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Sayfa ve İçerik Bilgileri</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/pages" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Sayfa Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sayfa_baslik" placeholder="Örn: Hakkımızda, Vizyonumuz" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">İçerik Tipi</label>
                                    <select class="form-select" name="sayfa_tip">
                                        <option value="1">Kurumsal Sayfa</option>
                                        <option value="2">Hizmet</option>
                                        <option value="3">Çözüm</option>
                                        <option value="4">Sözleşme</option>
                                    </select>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kısa Özet / Açıklama</label>
                                    <textarea class="form-control" name="sayfa_kisa" rows="2" placeholder="Listeleme ve kart alanları için kısa açıklama..."></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Detaylı İçerik</label>
                                    <textarea class="form-control ckeditor-init" id="sayfa_icerik" name="sayfa_icerik"></textarea>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Başlık (Title)</label>
                                    <input type="text" class="form-control" name="sayfa_title" placeholder="Tarayıcı sekme başlığı">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Açıklama (Description)</label>
                                    <input type="text" class="form-control" name="sayfa_description" placeholder="Arama motoru meta açıklaması">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kapak Görseli</label>
                                    <input type="file" class="form-control" name="sayfa_resim" accept="image/*">
                                </div>

                                <div class="col-xl-6 d-flex align-items-center gap-4 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="sayfa_durum" value="1" id="durumSwitch" checked>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="durumSwitch">Sayfa Aktif / Yayında</label>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Sayfayı Kaydet
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