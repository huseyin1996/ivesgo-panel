<?php 
if (!modulAktifMi($db, 'yorumlar') && !yetkisiVarMi("yorumlar", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Yorum Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="yorumlar/">Yorumlar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Yorum Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Yorum Detayları</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/comments" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="yorum_ad_soyad" placeholder="Örn: Mehmet Demir" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Unvan / Şirket</label>
                                    <input type="text" class="form-control" name="yorum_unvan" placeholder="Örn: Kurucu Ortak, XYZ Holding">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Yıldız Puanı (1 - 5)</label>
                                    <select class="form-select" name="yorum_puan">
                                        <option value="5">⭐⭐⭐⭐⭐ (5 Yıldız - Mükemmel)</option>
                                        <option value="4">⭐⭐⭐⭐ (4 Yıldız - Çok İyi)</option>
                                        <option value="3">⭐⭐⭐ (3 Yıldız - Normal)</option>
                                        <option value="2">⭐⭐ (2 Yıldız - Geliştirilmeli)</option>
                                        <option value="1">⭐ (1 Yıldız - Kötü)</option>
                                    </select>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kişi Fotoğrafı / Logo</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="yorum_resim" accept="image/*">
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Yorum Metni <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="yorum_metin" rows="4" placeholder="Müşterinin yaptığı değerlendirme yazısı..." required></textarea>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Yorumu Kaydet
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