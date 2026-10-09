<?php 
$modulAdi = 'markalar'; 

if (!modulAktifMi($db, 'kampanya_kupon') &&  !yetkisiVarMi($modulAdi, 'goruntule')) {
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
            <h1 class="page-title fw-medium fs-20 mb-0">Kampanyalar & Promosyonlar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">E-Ticaret</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kampanyalar</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Aktif ve Pasif Kampanyalar</div>
                        <a href="kampanya-ekle/" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Yeni Kampanya Ekle
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap w-100 dynamic-datatable" data-page="campaigns" data-type="kampanya">
                                <thead class="table-light">
                                    <tr>
                                        <th data-name="sira">Sıra No</th>
                                        <th data-name="kampanya_adi">Kampanya Adı</th>
                                        <th data-name="kampanya_kodu">Kupon Kodu</th>
                                        <th data-name="kampanya_turu">Kampanya Türü</th>
                                        <th data-name="deger">İndirim Değeri</th>
                                        <th data-name="durum" data-type="badge">Durum</th>
                                        <th data-name="id" data-type="islem" data-buttons="<?=$butonlar?>">İşlemler</th>
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