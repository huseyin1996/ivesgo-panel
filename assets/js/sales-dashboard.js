document.addEventListener("DOMContentLoaded", function () {
    const chartContainer = document.querySelector("#crypto-donut");
    
    if (chartContainer && !chartContainer.classList.contains("rendered")) {
        chartContainer.classList.add("rendered");

        // FormData ile postType gönderiyoruz
        let formData = new FormData();
        formData.append('postType', 'get_dashboard_data');

        fetch('request/dashboard', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(response => {
            if (response.durum === 'basarili') {
                
                // 1. İstatistik Kartlarını Doldurma
                if (response.istatistikler) {
                    const elToplam = document.querySelector("#stat-toplam-hizmet");
                    const elGecen = document.querySelector("#stat-suresi-gecenler");
                    const elOrt = document.querySelector("#stat-ortalama-gun");
                    const elTutar = document.querySelector("#stat-toplam-tutar");

                    if (elToplam) elToplam.innerText = response.istatistikler.toplam_hizmet;
                    if (elGecen) elGecen.innerText = response.istatistikler.suresi_gecenler;
                    if (elOrt) elOrt.innerText = response.istatistikler.ortalama_kalan_gun + " Gün";
                    if (elTutar) elTutar.innerText = response.istatistikler.toplam_tutar;
                }

                // 2. Donut Grafik Oluşturma
                var options = {
                    series: response.data,
                    chart: { height: 250, type: "donut" },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270,
                            donut: {
                                size: '75%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: { show: true, fontSize: '14px', color: '#495057', offsetY: -5 },
                                    value: { show: true, fontSize: '18px', fontWeight: 600, offsetY: 8, formatter: (val) => val + " Gün" },
                                    total: { show: true, showAlways: true, label: 'Hizmet Takibi', fontSize: '12px', color: '#8c9097', formatter: () => "Aktif" }
                                }
                            }
                        }
                    },
                    dataLabels: { enabled: false },
                    colors: ["var(--primary-color)", "rgba(var(--success-rgb), 1)", "rgba(var(--warning-rgb), 1)", "rgba(var(--danger-rgb), 1)"],
                    labels: response.labels,
                    legend: { show: false }
                };

                var chart = new ApexCharts(chartContainer, options);
                chart.render();

                // 3. Tabloyu Dinamik Doldurma
                const tabloGovdesi = document.querySelector("#crypto-assets-tbody");
                if (tabloGovdesi && response.hizmetler) {
                    tabloGovdesi.innerHTML = ""; 
                    
                    response.hizmetler.forEach(hizmet => {
                        let badgeClass = hizmet.suresi_gecti ? "bg-danger-transparent text-danger" : "bg-success-transparent text-success";
                        let durumMetni = hizmet.suresi_gecti ? "Süresi Geçti!" : hizmet.kalan_gun + " Gün Kaldı";
                        
                        let satir = `
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <p class="mb-0 fw-semibold">${hizmet.paket_adi}</p>
                                            <span class="text-muted fs-12">${hizmet.website}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="fw-medium">${hizmet.hizmet_uzat}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress progress-xs w-100 me-2" style="height: 6px; min-width: 80px;">
                                            <div class="progress-bar bg-primary" style="width: ${hizmet.kalan_yuzde}%"></div>
                                        </div>
                                        <span class="fs-11 text-muted">%${hizmet.kalan_yuzde}</span>
                                    </div>
                                </td>
                                <td><span class="badge ${badgeClass}">${durumMetni}</span></td>
                            </tr>
                        `;
                        tabloGovdesi.innerHTML += satir;
                    });
                }

            } else {
                console.error("Grafik verileri alınamadı.");
            }
        })
        .catch(error => console.error("Bağlantı hatası:", error));
    }
});


document.addEventListener("DOMContentLoaded", function () {
    let formData = new FormData();
    formData.append('postType', 'get_analytics_data');

    fetch('request/dashboard', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(response => {
        if (response.durum === 'basarili' && response.analytics) {
            const ga = response.analytics;

            // 1. Ana Kart Değerleri
            const elVisitors = document.querySelector("#val-visitors-online");
            const elBounce = document.querySelector("#val-bounce-rate");
            const elDuration = document.querySelector("#val-avg-duration");
            const elLead = document.querySelector("#val-lead-analytics");
            const elSessions = document.querySelector("#val-sessions");

            if (elVisitors) elVisitors.innerText = ga.visitors_online;
            if (elBounce) elBounce.innerText = ga.bounce_rate;
            if (elDuration) elDuration.innerText = ga.avg_duration;
            if (elLead) elLead.innerText = ga.lead_analytics;
            if (elSessions) elSessions.innerText = ga.sessions;

            // 2. Alt Dinamik Oranlar ve Metinler
            const change1 = document.querySelector("#change-visitor");
            const change2 = document.querySelector("#change-bounce");
            const change3 = document.querySelector("#change-duration");
            const change4 = document.querySelector("#change-lead");
            const change5 = document.querySelector("#change-session");

            if (change1) change1.innerText = ga.visitor_change;
            if (change2) change2.innerText = ga.bounce_change;
            if (change3) change3.innerText = ga.duration_change;
            if (change4) change4.innerText = ga.lead_change;
            if (change5) change5.innerText = ga.session_change;

            // 3. Birinci Grafik: Trafik Alan Grafiği (Area Chart)
            const mainChartEl = document.querySelector("#analytics-main-chart");
            if (mainChartEl && typeof ApexCharts !== 'undefined') {
                mainChartEl.innerHTML = ""; // İçini temizle (çakışmayı önle)
                var mainOptions = {
                    series: [{
                        name: 'Oturumlar',
                        data: [120, 200, 350, 420, 510, 550, parseInt((ga.sessions || "0").replace(/[^0-9]/g, '')) || 585]
                    }, {
                        name: 'Aktif Kullanıcı',
                        data: [90, 160, 280, 340, 410, 480, parseInt((ga.visitors_online || "0").replace(/[^0-9]/g, '')) || 531]
                    }],
                    chart: { height: 300, type: 'area', toolbar: { show: false } },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: { 
                        type: 'gradient', 
                        gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 90, 100] } 
                    },
                    colors: ["#0d6efd", "#198754"], 
                    xaxis: { categories: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'] },
                    grid: { borderColor: 'rgba(140, 144, 151, 0.15)', strokeDashArray: 3 }
                };
                new ApexCharts(mainChartEl, mainOptions).render();
            }

            // 4. İkinci Grafik: Dağılım Donut Grafiği (Donut Chart)
            const donutChartEl = document.querySelector("#analytics-donut-chart");
            if (donutChartEl && typeof ApexCharts !== 'undefined') {
                donutChartEl.innerHTML = ""; // İçini temizle
                var donutOptions = {
                    series: [45, 30, 25],
                    chart: { height: 260, type: 'donut' },
                    labels: ['Doğrudan Trafik', 'Arama Motorları', 'Sosyal Medya'],
                    colors: ["#0d6efd", "#198754", "#ffc107"],
                    legend: { position: 'bottom' },
                    dataLabels: { enabled: false }
                };
                new ApexCharts(donutChartEl, donutOptions).render();
            }

            // 5. Veritabanı Tablosu
            const tbody = document.querySelector("#local-db-tbody");
            if (tbody && response.son_kayitlar && response.son_kayitlar.length > 0) {
                tbody.innerHTML = "";
                response.son_kayitlar.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td>#${item.id || ''}</td>
                            <td class="fw-semibold">${item.baslik || item.sayfa_adi || 'Kurumsal Kayıt'}</td>
                            <td>${item.tarih || item.created_at || 'Bugün'}</td>
                            <td><span class="badge bg-success-transparent">Yayında</span></td>
                        </tr>`;
                });
            } else if (tbody) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Henüz kayıt bulunmuyor.</td></tr>`;
            }
        }
    })
    .catch(err => console.error("Veri yükleme hatası:", err));
});