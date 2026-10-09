document.addEventListener('DOMContentLoaded', async () => {
    const genelBakisTab = document.getElementById('genelBakis');
    if (!genelBakisTab) return;

    const musteriId = genelBakisTab.getAttribute('data-customer-id');
    if (!musteriId) return;

    try {
        const res = await fetch('request/customer_charts_data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify({ musteri_id: musteriId })
        });

        const response = await res.json();
        
        if (!response.success) {
            console.error('Grafik verisi alınamadı:', response.message);
            return;
        }

        const trendData = response.trend;
        const optionsTrend = {
            series: [
                {
                    name: 'Ziyaret Sayısı',
                    type: 'column',
                    data: trendData.visits
                },
                {
                    name: 'Alışveriş Tutarı',
                    type: 'line',
                    data: trendData.amounts
                }
            ],
            chart: {
                height: 310,
                type: 'line',
                stacked: false,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '35%',
                    borderRadius: 4
                }
            },
            xaxis: {
                categories: trendData.categories,
                labels: { style: { colors: '#8c9097', fontSize: '11px' } }
            },
            yaxis: [
                {
                    seriesName: 'Ziyaret Sayısı',
                    labels: { style: { colors: '#8c9097', fontSize: '11px' } }
                },
                {
                    seriesName: 'Alışveriş Tutarı',
                    opposite: true,
                    labels: {
                        style: { colors: '#8c9097', fontSize: '11px' },
                        formatter: function (val) {
                            return val >= 1000 ? (val / 1000) + 'K' : val;
                        }
                    }
                }
            ],
            colors: ["var(--primary-color)", "#f1c40f"],
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'center',
                markers: { radius: 12 }
            },
            grid: {
                borderColor: 'rgba(132, 145, 163, 0.1)',
                strokeDashArray: 3
            }
        };

        const trendEl = document.querySelector("#customerTrendChart");
        if (trendEl) {
            trendEl.innerHTML = '';
            new ApexCharts(trendEl, optionsTrend).render();
        }

        const segmentData = response.segment;
        const optionsSegment = {
            series: segmentData.series,
            labels: segmentData.labels,
            chart: {
                height: 310,
                type: 'donut'
            },
            dataLabels: { enabled: false },
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '11px'
            },
            stroke: { width: 2, colors: ["#fff"] },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Ödeme Yöntemleri',
                                fontSize: '12px',
                                color: '#495057'
                            }
                        }
                    }
                }
            },
            colors: ["#6c5ce7", "#0dcaf0", "#f1c40f", "#20c997", "#fd7e14"]
        };

        const segmentEl = document.querySelector("#customerSegmentChart");
        if (segmentEl) {
            segmentEl.innerHTML = '';
            new ApexCharts(segmentEl, optionsSegment).render();
        }

    } catch (err) {
        console.error('Müşteri grafik yükleme hatası:', err);
    }
});