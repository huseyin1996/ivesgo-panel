<?php 
if (!modulAktifMi($db, 'sayfa') && !yetkisiVarMi("blog", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$blog_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_bloglar WHERE blog_id = :blog_id");
$sor->execute(["blog_id" => $blog_id]);

if($sor->rowCount() > 0){
    $blog = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."bloglar/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Blog Yazısı Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="bloglar/">Bloglar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Blog Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($blog['guncelleme_tarihi']) ? tarihSaat($blog['guncelleme_tarihi']) : tarihSaat($blog['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/blogs" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$blog['blog_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Blog Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="blog_baslik" value="<?=htmlspecialchars($blog['blog_baslik'])?>" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kısa Özet (Lead / Giriş Yazısı)</label>
                                    <textarea class="form-control" name="blog_kisa" rows="2"><?=htmlspecialchars($blog['blog_kisa'] ?? '')?></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Detaylı İçerik <span class="text-danger">*</span></label>
                                    <textarea class="form-control ckeditor-init" name="blog_icerik" id="blog_icerik" required><?=$blog['blog_icerik']?></textarea>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Başlık (Title)</label>
                                    <input type="text" class="form-control" name="blog_title" value="<?=htmlspecialchars($blog['blog_title'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">SEO Açıklama (Description)</label>
                                    <input type="text" class="form-control" name="blog_description" value="<?=htmlspecialchars($blog['blog_description'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Etiketler (Tags)</label>
                                    <input type="text" class="form-control" name="blog_etiketler" value="<?=htmlspecialchars($blog['blog_etiketler'] ?? '')?>" placeholder="Virgülle ayırın">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kapak Görselini Güncelle</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="blog_resim" accept="image/*">
                                    <?php if (!empty($blog['blog_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/blog/<?=$blog['blog_resim']?>" alt="Görsel" class="img-thumbnail me-3 shadow-sm" width="100">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Görseli Sil
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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