<?php 
if (!modulAktifMi($db, 'yorumlar') && !yetkisiVarMi("yorumlar", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$yorum_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_yorumlar WHERE yorum_id = :yorum_id");
$sor->execute(["yorum_id" => $yorum_id]);

if($sor->rowCount() > 0){
    $yorum = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."yorumlar/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Yorum Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="yorumlar/">Yorumlar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Yorum Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Yorum Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($yorum['guncelleme_tarihi']) ? tarihSaat($yorum['guncelleme_tarihi']) : tarihSaat($yorum['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/comments" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$yorum['yorum_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="yorum_ad_soyad" value="<?=htmlspecialchars($yorum['yorum_ad_soyad'])?>" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Unvan / Şirket</label>
                                    <input type="text" class="form-control" name="yorum_unvan" value="<?=htmlspecialchars($yorum['yorum_unvan'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Yıldız Puanı (1 - 5)</label>
                                    <select class="form-select" name="yorum_puan">
                                        <option value="5" <?=($yorum['yorum_puan']==5?'selected':'')?>>⭐⭐⭐⭐⭐ (5 Yıldız - Mükemmel)</option>
                                        <option value="4" <?=($yorum['yorum_puan']==4?'selected':'')?>>⭐⭐⭐⭐ (4 Yıldız - Çok İyi)</option>
                                        <option value="3" <?=($yorum['yorum_puan']==3?'selected':'')?>>⭐⭐⭐ (3 Yıldız - Normal)</option>
                                        <option value="2" <?=($yorum['yorum_puan']==2?'selected':'')?>>⭐⭐ (2 Yıldız - Geliştirilmeli)</option>
                                        <option value="1" <?=($yorum['yorum_puan']==1?'selected':'')?>>⭐ (1 Yıldız - Kötü)</option>
                                    </select>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Fotoğrafı Güncelle</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="yorum_resim" accept="image/*">
                                    <?php if (!empty($yorum['yorum_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/yorumlar/<?=$yorum['yorum_resim']?>" alt="Fotoğraf" class="img-thumbnail me-3 shadow-sm rounded-circle" width="60" height="60" style="object-fit:cover;">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Fotoğrafı Sil
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Yorum Metni <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="yorum_metin" rows="4" required><?=htmlspecialchars($yorum['yorum_metin'])?></textarea>
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