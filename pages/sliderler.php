<?php 
$modulAdi = 'slider'; // Yetki kontrol modül adı

if (!modulAktifMi($db, 'slider') && !yetkisiVarMi($modulAdi, 'goruntule')) {
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
            <h1 class="page-title fw-medium fs-20 mb-0">Slider & Manşet Yönetimi</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Yönetim</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sliderlar</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Aktif Slider Listesi</div>
                        <a href="<?=URL?>slider-ekle" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Yeni Slider Ekle
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap w-100 dynamic-datatable" data-page="slider" data-type="slider">
                                <thead class="table-light">
                                    <tr>
                                        <th data-name="fotograf_resim">Görsel</th>
                                        <th data-name="fotograf_baslik">Slider Başlığı</th>
                                        <th data-name="buton_yazi">Buton Metni</th>
                                        <th data-name="sira">Sıra</th>
                                        <th data-name="fotograf_durum" data-type="badge">Durum</th>
                                        <th data-name="fotograf_id" data-type="islem" data-buttons="<?=$butonlar?>">İşlemler</th>
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