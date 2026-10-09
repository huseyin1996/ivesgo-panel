<?php 
$modulAdi = 'sabit-sayfa'; 

if (modulAktifMi($db, 'sabit-sayfa') &&  !yetkisiVarMi($modulAdi, 'goruntule')) {
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
            <h1 class="page-title fw-medium fs-20 mb-0">Sabit Sayfalar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">İçerik Yönetimi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sabit Sayfalar</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="alert alert-secondary data-table-alert alert-dismissible fs-15 fade show mb-4">
            Site genelindeki <strong class="text-black">Sabit Sayfalarınızı</strong> (İletişim, Hakkımızda vb.) bu alandan yönetebilirsiniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Tüm Sabit Sayfalar Listesi</div>
                        <a href="sabit-sayfa-ekle" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Yeni Sayfa Ekle</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100 dynamic-datatable" data-page="statics" data-type="sabit-sayfa">
                                <thead>
                                    <tr>
                                        <th data-name="sira">Sıra No</th>
                                        <th data-name="sayfa_resim">Görsel</th>
                                        <th data-name="baslik">Sayfa Başlığı</th>
                                        <th data-name="sayfa_url">Sayfa URL / Key</th>
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