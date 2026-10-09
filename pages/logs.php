
<div class="main-content app-content">

    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Tüm Loglar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Loglar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tüm Loglar</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="alert alert-secondary data-table-alert alert-dismissible fs-15 fade show mb-4">
            Kayıtlı olan tüm <strong class="text-black">Sistem Loglar</strong> bu alandan görüntüleyebilirsiniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Tüm Sistem Logları Listesi</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100 dynamic-datatable" data-page="logs" data-type="log">
                                <thead>
                                    <tr>
                                        <th data-name="sira">Sıra No</th>
                                        <th data-name="uye">Üye Adı Soyadı</th>
                                        <th data-name="islem_turu">İşlem Türü</th>
                                        <th data-name="aciklama">Açıklama</th>
                                        <th data-name="ip">IP Adresi</th>
                                        <th data-name="tarih">İşlem Tarihi</th>
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