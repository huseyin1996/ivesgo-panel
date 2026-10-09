<?php 
if (!modulAktifMi($db, 'sayfa') && !yetkisiVarMi("blog", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yeni Blog Yazısı Ekle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="bloglar/">Bloglar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Blog İçeriği ve SEO Detayları</div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/blogs" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Blog Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="blog_baslik" placeholder="Örn: Kurumsal Web Sitesi Nasıl Olmalı?" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kısa Özet (Lead / Giriş Yazısı)</label>
                                    <textarea class="form-control" name="blog_kisa" rows="2" placeholder="Listeleme sayfalarında görünecek kısa açıklama..."></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Detaylı İçerik <span class="text-danger">*</span></label>
                                    <textarea class="form-control ckeditor-init" name="blog_icerik" id="blog_icerik" placeholder="Blog makale içeriği..." required></textarea>
                                    
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Başlık (Title)</label>
                                    <input type="text" class="form-control" name="blog_title" placeholder="Tarayıcı sekme başlığı">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Açıklama (Description)</label>
                                    <input type="text" class="form-control" name="blog_description" placeholder="Arama motoru meta açıklaması">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Etiketler (Tags)</label>
                                    <input type="text" class="form-control" name="blog_etiketler" placeholder="Örn: yazilim, seo, kurumsal (virgülle ayırın)">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kapak Görseli</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="blog_resim" accept="image/*">
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Blog Yazısını Kaydet
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