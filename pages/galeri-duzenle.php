<?php 
if (!modulAktifMi($db, 'galeri') && !yetkisiVarMi("galeri", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$galeri_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_galeri WHERE galeri_id = :galeri_id");
$sor->execute(["galeri_id" => $galeri_id]);

if($sor->rowCount() > 0){
    $galeri = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."galeri/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Medya Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="galeri/">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medya Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Medya Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($galeri['guncelleme_tarihi']) ? tarihSaat($galeri['guncelleme_tarihi']) : tarihSaat($galeri['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/gallery" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$galeri['galeri_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Başlık <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="galeri_baslik" value="<?=$galeri['galeri_baslik']?>" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Medya Tipi</label>
                                    <select class="form-select" name="galeri_tip" id="galeriTipSelect">
                                        <option value="1" <?=($galeri['galeri_tip']==1?'selected':'')?>>Fotoğraf Galeri</option>
                                        <option value="2" <?=($galeri['galeri_tip']==2?'selected':'')?>>Video Galeri</option>
                                        <option value="3" <?=($galeri['galeri_tip']==3?'selected':'')?>>Referans Logo</option>
                                        <option value="4" <?=($galeri['galeri_tip']==4?'selected':'')?>>Sertifika</option>
                                    </select>
                                </div>

                                <div class="col-xl-12" id="videoUrlContainer" style="display: <?=($galeri['galeri_tip']==2?'block':'none')?>;">
                                    <label class="form-label fw-bold text-success">Video URL (YouTube / Embed Link)</label>
                                    <input type="text" class="form-control" name="video_url" value="<?=htmlspecialchars($galeri['video_url'] ?? '')?>" placeholder="Örn: https://www.youtube.com/watch?v=...">
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Görseli Güncelle</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="galeri_resim" accept="image/*">
                                    <?php if (!empty($galeri['galeri_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/galeri/<?=$galeri['galeri_resim']?>" alt="Görsel" class="img-thumbnail me-3 shadow-sm" width="100">
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