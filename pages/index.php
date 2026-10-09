<?php 
$tema_arr      = json_decode($ayar["tema_ayarlari"] ?? '{}', true);
$tema_cek = $tema_arr["tema_ayar"] ?? [];
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-semibold fs-20 mb-0">Anasayfa</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Anasayfa</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid page-container main-body-container">
        <?php if (!empty($tema_cek["ga_property_id"])): ?>
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1">
                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div></div>
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Çevrim içi Ziyaretçi</p>
                                            <div class="fw-semibold fs-22" id="val-visitors-online">0</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-primary-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-primary anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 d-inline-flex align-items-center gap-2 text-muted">
                                        <span class="bg-success-transparent px-1 rounded-pill d-inline-flex align-items-center gap-1 fs-12 fw-medium">
                                            <i class="ti ti-arrow-up"></i>
                                            <span id="change-visitor">+7.5K+</span>
                                        </span>
                                        <span class="fs-12 fw-medium me-1">Kullanıcı</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div></div>
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Hemen Çıkma Oranı</p>
                                            <div class="fw-semibold fs-22 text-danger" id="val-bounce-rate">0%</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-secondary-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-secondary anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="m6.89 12.45 1.05-2.1 3.14 7.06c.16.36.52.59.91.59h.05c.41-.02.77-.29.9-.68l2.98-8.93 1.11 3.89c.12.43.52.73.96.73h4v-2h-3.25l-1.79-6.27c-.12-.42-.5-.72-.94-.73a.98.98 0 0 0-.97.68l-3.18 9.55L8.91 7.6c-.16-.35-.5-.58-.89-.59-.41-.04-.74.21-.92.55l-1.72 3.45H2v2h4c.38 0 .73-.21.89-.55Z"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 d-inline-flex align-items-center gap-2 text-muted">
                                        <span class="bg-warning-transparent px-1 rounded-pill d-inline-flex align-items-center gap-1 fs-12 fw-medium text-warning">
                                            <i class="ti ti-alert-circle"></i> 
                                            <span id="change-bounce"></span>
                                        </span>
                                        <span class="fs-12 fw-medium me-1"> Süre</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div></div>
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Ort. Ziyaret Süresi</p>
                                            <div class="fw-semibold fs-22" id="val-avg-duration">0m 0s</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-success-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-success anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.58 2 2 6.58 2 12s4.58 10 10 10 10-4.58 10-10S17.42 2 12 2m0 18c-4.34 0-8-3.66-8-8s3.66-8 8-8 8 3.66 8 8-3.66 8-8 8"/><path d="M13 7h-2v6h6v-2h-4z"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 d-inline-flex align-items-center gap-2 text-muted">
                                        <span class="bg-success-transparent px-1 rounded-pill d-inline-flex align-items-center gap-1 fs-12 fw-medium">
                                            <i class="ti ti-alert-circle"></i> 
                                            <span id="change-duration"></span>
                                        </span>
                                        <span class="fs-12 fw-medium me-1">Ortamala Oturum Süresi</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div></div>
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Lead Analitiği</p>
                                            <div class="fw-semibold fs-22" id="val-lead-analytics">0</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-warning-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-warning anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2c-.55 0-1 .45-1 1v7c0 .55.45 1 1 1h7c.55 0 1-.45 1-1 0-4.41-3.59-8-8-8m1 7V4.08c2.51.42 4.49 2.41 4.92 4.92z"/><path d="M10.51 22A8.5 8.5 0 0 0 19 14.06c.02-.28-.08-.55-.27-.75s-.45-.32-.73-.32h-6.99V6a.97.97 0 0 0-.32-.73c-.2-.19-.46-.28-.75-.27-2.06.13-4 1.01-5.45 2.47C2.88 9.08 2 11.22 2 13.49s.89 4.41 2.49 6.02A8.46 8.46 0 0 0 10.51 22M5.91 8.88c.86-.86 1.93-1.45 3.1-1.73v6.83c0 .55.45 1 1 1h6.83a6.4 6.4 0 0 1-1.73 3.1c-1.23 1.23-2.87 1.91-4.6 1.91s-3.37-.68-4.6-1.91S4 15.21 4 13.48s.68-3.38 1.91-4.61Z"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 d-inline-flex align-items-center gap-2 text-muted">
                                        <span class="bg-success-transparent px-1 rounded-pill d-inline-flex align-items-center gap-1 fs-12 fw-medium">
                                            <i class="ti ti-alert-circle"></i>
                                            <span id="change-lead"></span>
                                        </span>
                                        <span class="fs-12 fw-medium me-1"> Kullanıcı</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div></div>
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Toplam Oturumlar</p>
                                            <div class="fw-semibold fs-22" id="val-sessions">0</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-danger-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-danger anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"/><path d="M18 14v4h4"/><path d="M14 18a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M15 3v4"/><path d="M7 3v4"/><path d="M3 11h16"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 d-inline-flex align-items-center gap-2 text-muted">
                                        <span class="bg-success-transparent px-1 rounded-pill d-inline-flex align-items-center gap-1 fs-12 fw-medium">
                                            <i class="ti ti-alert-circle"></i>
                                            <span id="change-session"></span>
                                        </span>
                                        <span class="fs-12 fw-medium me-1">Kullanıcı</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-8 col-xl-7">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Haftalık Trafik ve Oturum Akışı</div>
                        </div>
                        <div class="card-body">
                            <div id="analytics-main-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Trafik Kaynakları Dağılımı</div>
                        </div>
                        <div class="card-body">
                            <div id="analytics-donut-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Veritabanı Son Eklenen İçerikler</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Başlık / Sayfa Adı</th>
                                            <th>Tarih</th>
                                            <th>Durum</th>
                                        </tr>
                                    </thead>
                                    <tbody id="local-db-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        
        <?php if (!empty($ayar['api_token'])): ?>
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1">
                        
                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Toplam Hizmet</p>
                                            <div class="fw-semibold fs-22" id="stat-toplam-hizmet">0</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-primary-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-primary anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/><path d="M3 14m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/><path d="M7 6l0 .01"/><path d="M7 16l0 .01"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Süresi Dolanlar</p>
                                            <div class="fw-semibold fs-22 text-danger" id="stat-suresi-gecenler">0</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-danger-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-danger anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.875h16.214a1.914 1.914 0 0 0 1.636 -2.875l-8.106 -13.534a1.914 1.914 0 0 0 -3.274 0z"/><path d="M12 16h.01"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Ort. Kalan Süre</p>
                                            <div class="fw-semibold fs-22" id="stat-ortalama-gun">0 Gün</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-success-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-success anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/><path d="M12 7v5l3 3"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Toplam Tutar</p>
                                            <div class="fw-semibold fs-22" id="stat-toplam-tutar">0 ₺</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-warning-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-warning anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"/><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4z"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="flex-fill">
                                            <p class="text-muted mb-2">Sistem Durumu</p>
                                            <div class="fw-semibold fs-22 text-success">Aktif</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="anal-body">
                                                <div class="bg-success-transparent anal-icon-bg"></div>
                                                <div class="rounded avatar avatar-md bg-success anal-icon text-white d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-activity"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h4l3 8l4 -16l3 8h4"/></svg>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Hizmet Süreleri ve Kalan Haklar Mimarisi</div>
                        </div>
                        <div class="card-body p-0">  
                            <div class="row g-0 align-items-center">
                                <div class="col-lg-4 border-end py-4 d-flex justify-content-center align-items-center">
                                    <div id="crypto-donut"></div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="table-responsive p-3">
                                        <table class="table table-borderless align-middle text-nowrap mb-0">
                                            <thead>
                                                <tr class="text-muted fs-11">
                                                    <th>HİZMET / SİTE</th>
                                                    <th>BİTİŞ TARİHİ</th>
                                                    <th>KALAN ORAN (%)</th>
                                                    <th>DURUM</th>
                                                </tr>
                                            </thead>
                                            <tbody id="crypto-assets-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

    </div>
</div>