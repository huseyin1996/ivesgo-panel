<?php 
if (!modulAktifMi($db, 'sabit-sayfa') && !yetkisiVarMi("sabit-sayfa", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_sabit_sayfalar WHERE id = ?");
$sor->execute([$id]);

if($sor->rowCount() > 0){
    $cek = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."sabit-sayfalar/");
    exit;
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sabit Sayfa Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sabit-sayfalar/">Sabit Sayfalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sabit Sayfa Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Sabit Sayfa Düzenle: <b><?=htmlspecialchars($cek['baslik'])?></b></div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/statics" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="baslik" class="form-label">Sayfa Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="baslik" name="baslik" value="<?=htmlspecialchars($cek['baslik'])?>" required>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="sayfa_url" class="form-label">Sayfa URL / Key</label>
                                    <input type="text" class="form-control" id="sayfa_url" name="sayfa_url" value="<?=htmlspecialchars($cek['sayfa_url'])?>">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?=htmlspecialchars($cek['title'] ?? '')?>">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="sayfa_resim" class="form-label">Sayfa Resmi</label>
                                    <input class="form-control py-1" type="file" id="sayfa_resim" name="sayfa_resim" accept="image/*">
                                    
                                    <?php if (!empty($cek['sayfa_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/systems/<?=$cek['sayfa_resim']?>" alt="Görsel" class="img-thumbnail me-3 shadow-sm" width="80" height="60" style="object-fit:cover;">
                                                 
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Mevcut Resmi Sil
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?=htmlspecialchars($cek['description'] ?? '')?></textarea>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>