<?php 
if (!yetkisiVarMi("markalar", 'ekle')) {
    header("Location:" . URL . "index");
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Markalar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Markalar</a></li>
                <li class="breadcrumb-item"><a href="musteriler/">Tüm Markalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Marka Ekle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Marka Ekle
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/brands" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="postType" value="Add">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="marka_adi" class="form-label">Marka Adı</label>
                                    <input type="text" class="form-control" id="marka_adi" name="marka_adi" placeholder="Marka Adı Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_title" class="form-label">Marka Title</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Marka Title Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_description" class="form-label">Marka Description</label>
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Marka Description Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="marka_logo" class="form-label">Marka Logo</label>
                                    <input class="form-control py-1" type="file" id="marka_logo" name="marka_logo">
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