<?php
    if (!yetkisiVarMi("markalar", 'duzenle')) {
        header("Location:" . URL . "index");
    }
    $sor = $db->prepare("SELECT * FROM i_markalar WHERE id=:id");
    $sor->execute(array("id" => $par[1]));
    if($sor->rowCount() > 0){
        $cek = $sor->fetch(PDO::FETCH_ASSOC);
    }else{
        header("Location:".URL."musteriler/");
    }
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Markalar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Markalar</a></li>
                <li class="breadcrumb-item"><a href="musteriler/">Tüm Markalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Marka Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Marka Düzenle
                        </div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/brands" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="marka_adi" class="form-label">Marka Adı</label>
                                    <input type="text" class="form-control" id="marka_adi" name="marka_adi" value="<?=$cek['marka_adi']?>" placeholder="Marka Adı Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_title" class="form-label">Marka Title</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="<?=$cek['seo_title']?>" placeholder="Marka Title Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_description" class="form-label">Marka Description</label>
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" value="<?=$cek['seo_description']?>" placeholder="Marka Description Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="marka_logo" class="form-label">Marka Logo</label>
                                    <input class="form-control py-1" type="file" id="marka_logo" name="marka_logo">

                                    <?php if (!empty($cek['marka_logo'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/markalar/<?=$cek['marka_logo']?>" alt="Marka Görseli" class="img-thumbnail me-3 shadow-sm" width="100">
                                                 
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
                                    <button type="submit" class="btn btn-primary">Bilgileri Kaydet</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>