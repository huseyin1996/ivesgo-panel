<?php 
if (!modulAktifMi($db, 'ekibimiz') && !yetkisiVarMi("ekibimiz", 'duzenle')) {
    header("Location:" . URL . "index");
    exit;
}

$ekip_id = intval($par[1] ?? 0);
$sor = $db->prepare("SELECT * FROM i_ekibimiz WHERE ekip_id = :ekip_id");
$sor->execute(["ekip_id" => $ekip_id]);

if($sor->rowCount() > 0){
    $ekip = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:".URL."ekibimiz/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Ekip Üyesi Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="ekibimiz/">Ekip</a></li>
                <li class="breadcrumb-item active" aria-current="page">Üye Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Personel Bilgilerini Güncelle</div>
                        <div class="text-muted fs-12">
                            (Son Güncelleme: <?=(!empty($ekip['guncelleme_tarihi']) ? tarihSaat($ekip['guncelleme_tarihi']) : tarihSaat($ekip['olusturma_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/team" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$ekip['ekip_id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ekip_ad_soyad" value="<?=htmlspecialchars($ekip['ekip_ad_soyad'])?>" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Unvan / Pozisyon</label>
                                    <input type="text" class="form-control" name="ekip_unvan" value="<?=htmlspecialchars($ekip['ekip_unvan'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Telefon Numarası</label>
                                    <input type="text" class="form-control" name="ekip_telefon" value="<?=htmlspecialchars($ekip['ekip_telefon'] ?? '')?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">E-Posta Adresi</label>
                                    <input type="email" class="form-control" name="ekip_eposta" value="<?=htmlspecialchars($ekip['ekip_eposta'] ?? '')?>">
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Kısa Açıklama / Özet</label>
                                    <textarea class="form-control" name="ekip_kisa" rows="2"><?=htmlspecialchars($ekip['ekip_kisa'] ?? '')?></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Detaylı İçerik (Biyografi / Özgeçmiş)</label>
                                    <textarea class="form-control ckeditor-init" name="ekip_icerik" rows="6"><?=$ekip['ekip_icerik']?></textarea>
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label fw-bold">Profil Fotoğrafını Güncelle</label>
                                    <input type="file" class="form-control form-control-sm py-0 ps-2" name="ekip_resim" accept="image/*">
                                    <?php if (!empty($ekip['ekip_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/ekip/<?=$ekip['ekip_resim']?>" alt="Fotoğraf" class="img-thumbnail me-3 shadow-sm rounded-circle" width="80" height="80" style="object-fit:cover;">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Fotoğrafı Sil
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