<?php 
$modulAdi = 'menuler'; 

if (!modulAktifMi($db, 'menu') && !yetkisiVarMi($modulAdi, 'goruntule')) {
    header("Location:" . URL . "index");
    exit;
}

$butonlarDizi = [];
if (yetkisiVarMi($modulAdi, 'duzenle')) {
    $butonlarDizi[] = 'duzenle';
}
if (yetkisiVarMi($modulAdi, 'durum')) {
    $butonlarDizi[] = 'durum';
}
if (yetkisiVarMi($modulAdi, 'sil')) {
    $butonlarDizi[] = 'sil';
}

$butonlar = !empty($butonlarDizi) ? implode(',', $butonlarDizi) : 'yok';
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Navigasyon & Menü Yönetimi</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Yönetim</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menüler</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Kayıtlı Menü Öğeleri</div>
                        <a href="<?=URL?>menu-ekle" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Yeni Menü Ekle
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap w-100 dynamic-datatable" data-page="menus" data-type="menu">
                                <thead class="table-light">
                                    <tr>
                                        <th data-name="menu_icon">İkon</th>
                                        <th data-name="menu_baslik">Menü Başlığı</th>
                                        <th data-name="menu_url">URL / Link</th>
                                        <th data-name="ust_id">Üst Menü</th>
                                        <th data-name="sira">Sıra</th>
                                        <th data-name="menu_durum" data-type="badge">Durum</th>
                                        <th data-name="menu_id" data-type="islem" data-buttons="<?=$butonlar?>">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>