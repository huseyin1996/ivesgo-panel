<?php 
$modulAdi = 'urunler'; 

if (!modulAktifMi($db, 'urunler') && !yetkisiVarMi($modulAdi, 'goruntule')) {
    header("Location:" . URL . "index");
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
            <h1 class="page-title fw-medium fs-20 mb-0">Tüm Ürünler</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Ürünler - Hizmetler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tüm Ürünler</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="alert alert-secondary data-table-alert alert-dismissible fs-15 fade show mb-4">
            Kayıtlı olan tüm  <strong class="text-black">Ürünlerinizi</strong> bu alandan yönetebilirsiniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Tüm Ürünler Listesi</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100 dynamic-datatable" data-page="products" data-type="urun">
                                <thead>
                                    <tr>
                                        <th data-name="sira">Sıra No</th>
                                        <th data-name="kapak_resmi">Resim</th>
                                        <th data-name="urun_adi">Ürün Adı</th>
                                        <th data-name="stok_kodu">Stok Kodu</th>
                                        <th data-name="urun_fiyat">Ürün Fiyatı</th>
                                        <th data-name="urun_stok">Stok Miktarı</th>
                                        <th data-name="eklenme_tarihi">Kayıt Tarihi</th>
                                        <th data-name="durum" data-type="badge">Durum</th>
                                        <th data-name="id" data-type="islem" data-buttons="<?=$butonlar?>">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>