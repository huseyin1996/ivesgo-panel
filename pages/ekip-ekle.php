<?php 
if (!modulAktifMi($db, 'ekibimiz') && !yetkisiVarMi("ekibimiz", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Ekip Üyesi Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="ekibimiz/">Ekip</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ekip Üyesi Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Personel Bilgileri</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/team" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ekip_ad_soyad" placeholder="Örn: Ahmet Yılmaz" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Unvan / Pozisyon</label>
                                    <input type="text" class="form-control" name="ekip_unvan" placeholder="Örn: Kıdemli Yazılımcı">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Telefon Numarası</label>
                                    <input type="text" class="form-control" name="ekip_telefon" placeholder="0555 ...">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">E-Posta Adresi</label>
                                    <input type="email" class="form-control" name="ekip_eposta" placeholder="ahmet@sirket.com">
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kısa Açıklama / Özet</label>
                                    <textarea class="form-control" name="ekip_kisa" rows="2" placeholder="Listeleme alanları için kısa açıklama..."></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Detaylı İçerik (Biyografi / Özgeçmiş)</label>
                                    <textarea class="form-control ckeditor-init" name="ekip_icerik" rows="6" placeholder="Detay sayfası isteyenler için özgeçmiş yazısı..."></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Profil Fotoğrafı</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="ekip_resim" accept="image/*">
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Üyeyi Kaydet
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