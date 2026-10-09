<?php 
$modulAdi = 'kategoriler'; 

if (!modulAktifMi($db, 'kategoriler') && !yetkisiVarMi($modulAdi, 'goruntule')) {
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
            <h1 class="page-title fw-medium fs-20 mb-0">Tüm Kategoriler</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Kategoriler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tüm Kategoriler</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="alert alert-secondary data-table-alert alert-dismissible fs-15 fade show mb-4">
            Kayıtlı olan tüm  <strong class="text-black">Kategorilerinizi</strong> bu alandan yönetebilirsiniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Tüm Kategori Listesi</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100 dynamic-datatable" data-page="categorys" data-type="kategori">
                                <thead>
                                    <tr>
                                        <th data-name="sira">Sıra No</th>
                                        <th data-name="kategori_resim">Resim</th>
                                        <th data-name="kategori_adi">Kategori Adı</th>
                                        <th data-name="ust_id">Üst Kategori</th>
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