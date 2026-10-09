<?php 
if (!modulAktifMi($db, 'sabit-resim') && !yetkisiVarMi("sabit-resim", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_sabit_resimler WHERE id = ?");
$sor->execute([$id]);

if($sor->rowCount() > 0){
    $cek = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."sabit-resimler/");
    exit;
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sabit Resim Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sabit-resimler/">Sabit Resimler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sabit Resim Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Sabit Resmi Düzenle: <b><?=htmlspecialchars($cek['resim_baslik'])?></b></div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/staticimages" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="resim_baslik" class="form-label">Resim Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="resim_baslik" name="resim_baslik" value="<?=htmlspecialchars($cek['resim_baslik'])?>" required>
                                    <small class="text-muted">Sistem Key: <b><?=$cek['resim_adi']?></b></small>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="resim" class="form-label">Resim Dosyası</label>
                                    <input class="form-control py-1" type="file" id="resim" name="resim" accept="image/*">
                                    
                                    <?php if (!empty($cek['resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/systems/<?=$cek['resim']?>" alt="Sabit Görsel" class="img-thumbnail me-3 shadow-sm" width="80" height="60" style="object-fit:cover;">
                                                 
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