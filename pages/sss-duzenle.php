<?php 
if (!modulAktifMi($db, 'sss') && !yetkisiVarMi("sss", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$sss_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_sss WHERE sss_id = :sss_id");
$sor->execute(["sss_id" => $sss_id]);

if($sor->rowCount() > 0){
    $sss = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."sss/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Soru Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sss/">SSS</a></li>
                <li class="breadcrumb-item active" aria-current="page">Soru Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Soru Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($sss['guncelleme_tarihi']) ? tarihSaat($sss['guncelleme_tarihi']) : tarihSaat($sss['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/fqa" method="post">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$sss['sss_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Soru <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sss_soru" value="<?=htmlspecialchars($sss['sss_soru'])?>" required>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Cevap <span class="text-danger">*</span></label>
                                    <textarea class="form-control ckeditor-init" name="sss_cevap" rows="6" required><?=$sss['sss_cevap']?></textarea>
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