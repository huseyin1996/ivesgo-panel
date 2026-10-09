<?php 
$modulAdi = 'siparisler'; 

if (!modulAktifMi($db, 'siparisler') && !yetkisiVarMi($modulAdi, 'goruntule')) {
    header("Location:" . URL . "index");
}

$butonlarDizi = [];
if (yetkisiVarMi($modulAdi, 'duzenle')) {
    $butonlarDizi[] = 'duzenle';
}

if (yetkisiVarMi($modulAdi, 'sil')) {
    $butonlarDizi[] = 'sil';
}

$butonlar = !empty($butonlarDizi) ? implode(',', $butonlarDizi) : 'yok';
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Tüm Siparişler</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Siparişler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tüm Siparişler</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="card-title fw-bold">Sipariş Yönetimi</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-nowrap w-100 dynamic-datatable" data-page="orders" data-type="siparis">
                                <thead class="table-light">
                                    <tr>
                                        <th data-name="siparis_kodu">Sipariş Kodu</th>
                                        <th data-name="musteri_adi">Müşteri Adı</th>
                                        <th data-name="genel_toplam">Sipariş Tutarı</th>
                                        <th data-name="siparis_durumu">Sipariş Durumu</th>
                                        <th data-name="odeme_durumu">Ödeme Durumu</th>
                                        <th data-name="eklenme_tarihi">Tarih</th>
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