$(document).on("submit", ".postForm", function(e) {
    e.preventDefault();
    var post = $(this);
    
    // FormData nesnesi oluştur
    var formData = new FormData(post[0]);

    if (!post.find('input[name="csrf_token"]').length) {
        formData.append('csrf_token', $('meta[name="csrf-token"]').attr('content') || '');
    }

    if ($(".dropzone").length && dropzone.files.length > 0) {
        // Dropzone'dan dosya bilgilerini ekle
        dropzone.files.forEach(function(file) {
            formData.append('dosya[]', file, file.name);
        });
    }

    $.ajax({
        type: post.attr("method"),
        url: _url + post.attr("action"),
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: "Yükleniyor",
                text: "Lütfen Bekleyiniz",
                icon: "info",
                showConfirmButton: false
            });
        },
        success: function(data) {
            if (data.title) {
                if (data.reload) {
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.type,
                        customClass: {
                            confirmButton: "btn btn-info w-xs mt-2"
                        },
                        buttonsStyling: !1
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (data.url) {
                                location.href = data.url;
                            } else {
                                window.location.reload(true);
                            }
                        }
                    });
                } else {
                    Swal.fire(data.title, data.message, data.type);
                }
            } else {
                if (data.message) {
                    location.href = data.message;
                } else {
                    window.location.reload(true);
                }
            }
            return false;
        }
    });
});




$(document).ready(function() {
    musteriTipiKontrol();

    $('#musteri_tipi').on('change', function() {
        musteriTipiKontrol();
    });

    function musteriTipiKontrol() {
        var tip = $('#musteri_tipi').val();
        if (tip === 'bireysel') {
            $('.kurumsal-alan').slideUp();
            $('#lbl_vergi_no').text('TC Kimlik No');
        } else {
            $('.kurumsal-alan').slideDown();
            $('#lbl_vergi_no').text('Vergi No');
        }
    }
});


$(document).ready(function() {
    $(document).on('change', '#il_id', function() {
        var secilen_il = $(this).val();
        var $ilceSelect = $('#ilce_id');
        
        if(secilen_il) {
            $ilceSelect.html('<option value="">İlçeler yükleniyor...</option>');

            $.ajax({
                url: 'request/ilce_getir',
                type: 'POST',
                data: { 
                    il_id: secilen_il,
                    csrf_token: $('input[name="csrf_token"]').val()
                },
                success: function(response) {
                    $ilceSelect.html(response);
                    
                    //$ilceSelect.select2(); 
                }
            });
        } else {
            $ilceSelect.html('<option value="">Önce İl Seçiniz</option>');
        }
    });
});


$(document).ready(function() {
    
    var roxyFileman = _url + 'assets/libs/ckeditor/fileman/index.html';

    $('.ckeditor-init').each(function() {
        var editorId = $(this).attr('id');
        
        if (editorId && typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace(editorId, {
                filebrowserBrowseUrl: roxyFileman,
                filebrowserImageBrowseUrl: roxyFileman + '?type=image',
                removeDialogTabs: 'link:upload;image:upload',
                height: 350,
                language: 'tr'
            });
        }
    });
});

if ($(".order-page").length > 0) {
    document.addEventListener("DOMContentLoaded", function() {

        const musteriler = window.siparisMusterileri || [];
        const urunler = window.siparisUrunleri || [];
        
        const kargoLimiti = window.kargoMinLimit || 0;
        const standartKargo = window.kargoStandartUcret || 0;
        let kargoManuelGuncellendi = false;

        // 1. Genel Choices.js Başlatıcısı (Müşteri seçimi dahil data-trigger olanlar)
        const triggerElements = document.querySelectorAll("[data-trigger]");
        const choicesInstances = {};
        triggerElements.forEach(element => {
            choicesInstances[element.id || element.name] = new Choices(element, {
                allowHTML: true,
                placeholderValue: "Arama yapın...",
                searchPlaceholderValue: "Aranacak kelime...",
                itemSelectText: '',
                shouldSort: false,
                noResultsText: 'Sonuç bulunamadı',
                noChoicesText: 'Seçenek yok'
            });
        });

        const musteriSec = document.getElementById("musteri_sec");
        if (!musteriSec) return; 

        // Müşteri değiştiğinde form alanlarını doldurma (Choices.js change olayını yakalamak için hem native change hem de choices event'i dinlenir)
        musteriSec.addEventListener("change", function() {
            const m_id = this.value;
            if(m_id == 0 || m_id === "") {
                document.getElementById("f_ad_soyad").value = "";
                document.getElementById("f_firma_unvani").value = "";
                document.getElementById("f_eposta").value = "";
                document.getElementById("f_telefon").value = "";
                document.getElementById("f_vergi_dairesi").value = "";
                document.getElementById("f_vergi_no").value = "";
                document.getElementById("f_fatura_adres").value = "";
                document.getElementById("f_teslimat_adres").value = "";
            } else {
                const m = musteriler.find(x => x.id == m_id);
                if(m) {
                    document.getElementById("f_musteri_tipi").value = m.musteri_tipi || 'bireysel';
                    document.getElementById("f_ad_soyad").value = m.musteri_adi || '';
                    document.getElementById("f_firma_unvani").value = m.unvan || '';
                    document.getElementById("f_eposta").value = m.eposta || '';
                    document.getElementById("f_telefon").value = m.telefon || m.gsm || '';
                    document.getElementById("f_vergi_dairesi").value = m.vergi_dairesi || '';
                    document.getElementById("f_vergi_no").value = m.vergi_no || '';
                    document.getElementById("f_fatura_adres").value = m.fatura_adresi || '';
                    document.getElementById("f_teslimat_adres").value = m.sevk_adresi || '';
                }
            }
        });

        const satirEkleBtn = document.getElementById("satirEkleBtn");
        const urunSatirlari = document.getElementById("urunSatirlari");
        const bosSepetUyarisi = document.getElementById("bosSepetUyarisi");
        const kargoInp = document.getElementById("kargo_ucreti");
        const indirimInp = document.getElementById("indirim_toplam");
        const kargoOtoBtn = document.getElementById("kargoOtoBtn");
        const kampanyaSec = document.getElementById("kampanya_sec");

        let urunOptionsHTML = '<option value="">-- Ürün Seçiniz --</option>';
        urunler.forEach(u => {
            const fiyat = u.urun_indirim > 0 ? parseFloat(u.urun_indirim) : parseFloat(u.urun_fiyat);
            urunOptionsHTML += `<option value="${u.urun_id}" data-fiyat="${fiyat}" data-kdv="${u.urun_kdv}" data-stok="${u.urun_stok}">[${u.stok_kodu}] ${u.urun_adi} (${fiyat} ₺)</option>`;
        });

        if(satirEkleBtn) {
            satirEkleBtn.addEventListener("click", function() {
                if(bosSepetUyarisi) bosSepetUyarisi.style.display = "none";

                const tr = document.createElement("tr");
                tr.className = "sepet-satir";
                
                tr.innerHTML = `
                    <td>
                        <select class="form-select urun-select" name="urun_id[]" required>
                            ${urunOptionsHTML}
                        </select>
                    </td>
                    <td class="text-center text-muted birim-fiyat-txt">0,00 ₺</td>
                    <td>
                        <select class="form-select form-select-sm kdv-durum-select" name="kdv_durum[]">
                            <option value="2">Dahil</option>
                            <option value="1">Hariç (+KDV)</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center miktar-input" name="miktar[]" value="1" min="1" required>
                    </td>
                    <td class="text-end fw-bold text-dark satir-toplam-txt">0,00 ₺</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger satir-sil-btn"><i class="bi bi-trash"></i></button>
                    </td>
                `;

                urunSatirlari.appendChild(tr);

                // Yeni eklenen satırdaki ürün select'ini Choices.js ile aktif hale getiriyoruz
                const yeniSelect = tr.querySelector('.urun-select');
                if (window.Choices && yeniSelect) {
                    new Choices(yeniSelect, {
                        allowHTML: true,
                        placeholderValue: "Ürün ara...",
                        searchPlaceholderValue: "Ürün adı veya kodu yazın...",
                        itemSelectText: '',
                        shouldSort: false,
                        noResultsText: 'Sonuç bulunamadı',
                        noChoicesText: 'Seçenek yok'
                    });
                }

                canliHesapla();
            });
        }

        if(urunSatirlari) {
            // Choices.js DOM yapısını değiştirdiği için change olayını document veya üst kapsayıcı üzerinden yakalıyoruz
            $(urunSatirlari).on("change", ".urun-select, .kdv-durum-select", function() {
                satirGuncelle(this.closest("tr"));
            });

            urunSatirlari.addEventListener("input", function(e) {
                if(e.target.classList.contains("miktar-input")) {
                    satirGuncelle(e.target.closest("tr"));
                }
            });

            urunSatirlari.addEventListener("click", function(e) {
                if(e.target.closest(".satir-sil-btn")) {
                    e.target.closest("tr").remove();
                    if(urunSatirlari.children.length === 0 && bosSepetUyarisi) {
                        bosSepetUyarisi.style.display = "block";
                    }
                    canliHesapla();
                }
            });
        }

        if(kargoInp) {
            kargoInp.addEventListener("input", function() {
                kargoManuelGuncellendi = true;
                canliHesapla();
            });
        }
        if(indirimInp) {
            indirimInp.addEventListener("input", canliHesapla);
        }
        if(kargoOtoBtn) {
            kargoOtoBtn.addEventListener("click", function() {
                kargoManuelGuncellendi = false;
                canliHesapla();
            });
        }
        if(kampanyaSec) {
            kampanyaSec.addEventListener("change", canliHesapla);
        }

        function satirGuncelle(tr) {
            const select = tr.querySelector(".urun-select");
            const miktarInp = tr.querySelector(".miktar-input");
            const kdvSelect = tr.querySelector(".kdv-durum-select");
            const birimTxt = tr.querySelector(".birim-fiyat-txt");
            const toplamTxt = tr.querySelector(".satir-toplam-txt");

            if(!select || !miktarInp || !kdvSelect) return;

            const opt = select.options[select.selectedIndex];
            
            if(opt && opt.value !== "") {
                const fiyat = parseFloat(opt.dataset.fiyat);
                const kdv = parseFloat(opt.dataset.kdv);
                const miktar = parseInt(miktarInp.value) || 1;
                const kdvDurumu = parseInt(kdvSelect.value);

                let satirTopKdvli = 0;
                let kdvHaricTutar = 0;
                let kdvTutari = 0;

                if (kdvDurumu === 1) { 
                    kdvHaricTutar = fiyat * miktar;
                    kdvTutari = (kdvHaricTutar * kdv) / 100;
                    satirTopKdvli = kdvHaricTutar + kdvTutari;
                } else { 
                    satirTopKdvli = fiyat * miktar;
                    kdvHaricTutar = satirTopKdvli / (1 + (kdv / 100));
                    kdvTutari = satirTopKdvli - kdvHaricTutar;
                }
                
                let badgeRenk = kdvDurumu === 1 ? 'text-danger' : 'text-success';
                let badgeMetin = kdvDurumu === 1 ? '+Eklenecek' : 'İçinde';

                if(birimTxt) birimTxt.innerHTML = `${fiyat.toLocaleString('tr-TR', {minimumFractionDigits: 2})} ₺ <br><small class="${badgeRenk}" style="font-size:10px;">%${kdv} KDV ${badgeMetin}</small>`;
                if(toplamTxt) toplamTxt.innerText = `${satirTopKdvli.toLocaleString('tr-TR', {minimumFractionDigits: 2})} ₺`;
                
                tr.dataset.aratope = kdvHaricTutar;
                tr.dataset.kdvtope = kdvTutari;
            } else {
                if(birimTxt) birimTxt.innerText = "0,00 ₺";
                if(toplamTxt) toplamTxt.innerText = "0,00 ₺";
                tr.dataset.aratope = 0;
                tr.dataset.kdvtope = 0;
            }
            
            canliHesapla();
        }

        function canliHesapla() {
            let araToplam = 0;
            let kdvToplam = 0;

            document.querySelectorAll(".sepet-satir").forEach(tr => {
                araToplam += parseFloat(tr.dataset.aratope || 0);
                kdvToplam += parseFloat(tr.dataset.kdvtope || 0);
            });

            let sepetUrunToplami = araToplam + kdvToplam;
            let kampanyaIndirimi = 0;
            let hesaplananKargo = 0;

            if(kampanyaSec && kampanyaSec.value > 0) {
                const opt = kampanyaSec.options[kampanyaSec.selectedIndex];
                const tur = opt.dataset.tur;
                const deger = parseFloat(opt.dataset.deger) || 0;
                const minTutar = parseFloat(opt.dataset.min) || 0;

                if(sepetUrunToplami >= minTutar) {
                    if(tur === 'yuzde_indirim') {
                        kampanyaIndirimi = (sepetUrunToplami * deger) / 100;
                    } else if(tur === 'tutar_indirim') {
                        kampanyaIndirimi = deger;
                    } else if(tur === 'ucretsiz_kargo') {
                        hesaplananKargo = 0;
                        kargoManuelGuncellendi = true;
                    }
                }
            }

            if (!kargoManuelGuncellendi && kargoInp) {
                if (sepetUrunToplami === 0) {
                    hesaplananKargo = 0;
                } else if (sepetUrunToplami >= kargoLimiti && kargoLimiti > 0) {
                    hesaplananKargo = 0;
                } else {
                    hesaplananKargo = standartKargo;
                }
                kargoInp.value = hesaplananKargo.toFixed(2);
            }

            const kargo = kargoInp ? (parseFloat(kargoInp.value) || 0) : 0;
            const manuelIndirim = indirimInp ? (parseFloat(indirimInp.value) || 0) : 0;
            const toplamIndirim = kampanyaIndirimi + manuelIndirim;

            let kargoIndirimFarki = kargo - toplamIndirim;
            let genelToplam = sepetUrunToplami + kargo - toplamIndirim;
            if(genelToplam < 0) genelToplam = 0;

            const ozetAra = document.getElementById("ozetAraToplam");
            const ozetKdv = document.getElementById("ozetKdvToplam");
            const ozetKargo = document.getElementById("ozetKargoIndirim");
            const ozetGenel = document.getElementById("ozetGenelToplam");

            if(ozetAra) ozetAra.innerText = araToplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + " ₺";
            if(ozetKdv) ozetKdv.innerText = kdvToplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + " ₺";
            
            if(ozetKargo) {
                let kargoRenk = kargoIndirimFarki > 0 ? 'text-danger' : (kargoIndirimFarki < 0 ? 'text-success' : 'text-muted');
                let isaret = kargoIndirimFarki > 0 ? '+' : '';
                ozetKargo.className = `fw-semibold ${kargoRenk}`;
                ozetKargo.innerText = isaret + kargoIndirimFarki.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + " ₺";
            }
            
            if(ozetGenel) ozetGenel.innerText = genelToplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + " ₺";
        }

        document.querySelectorAll(".sepet-satir").forEach(tr => {
            if(!tr.dataset.aratope) {
                satirGuncelle(tr);
            }
        });
        canliHesapla();
    });
}


document.addEventListener("DOMContentLoaded", function() {
    const kampanyaTuru = document.getElementById('kampanyaTuru');
    
    // Eğer sayfada bu eleman varsa dinleyiciyi ekle (Hata almayı önler)
    if (kampanyaTuru) {
        kampanyaTuru.addEventListener('change', function() {
            const degerAlani = document.getElementById('indirimDegerAlani');
            if (degerAlani) {
                if(this.value === 'ucretsiz_kargo') {
                    degerAlani.style.display = 'none';
                } else {
                    degerAlani.style.display = 'block';
                }
            }
        });
    }
});


// raporlar sayfası


document.addEventListener("DOMContentLoaded", function () {
    
    // Eğer sayfada rapor verileri tanımlı değilse fonksiyondan çık
    if (typeof window.raporVerileri === 'undefined') return;

    const data = window.raporVerileri;

    // 1. Ciro & Satış Trend Grafiği (Line Chart)
    const salesOptions = {
        series: [{
            name: 'Ciro (₺)',
            data: data.aylikCirolar // <-- Veritabanından gelen dinamik ciro dizisi
        }, {
            name: 'Sipariş Adeti',
            data: data.aylikAdetler // <-- Veritabanından gelen dinamik sipariş adet dizisi
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        colors: ['#28a745', '#6366f1'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
        },
        tooltip: { shared: true, intersect: false }
    };
    
    const salesEl = document.querySelector("#sales-trend-chart");
    if (salesEl) {
        new ApexCharts(salesEl, salesOptions).render();
    }

    // 2. Ödeme Yöntemleri Dağılımı (Veritabanından Dinamik Donut Chart)
    const paymentOptions = {
        series: data.odemeVeriler,
        labels: data.odemeEtiketler,
        chart: {
            height: 350,
            type: 'donut',
        },
        colors: ['#6366f1', '#17a2b8', '#ffc107', '#dc3545'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true }
    };
    const paymentEl = document.querySelector("#payment-methods-chart");
    if (paymentEl) {
        new ApexCharts(paymentEl, paymentOptions).render();
    }

    // 3. Kampanya Performansları (Veritabanından Dinamik Bar Chart)
    const campaignOptions = {
        series: [{
            name: 'Kullanım',
            data: data.kampanyaSayilar
        }],
        chart: {
            height: 300,
            type: 'bar',
            toolbar: { show: false }
        },
        colors: ['#0d6efd'],
        plotOptions: {
            bar: { borderRadius: 4, horizontal: true }
        },
        xaxis: {
            categories: data.kampanyaAdlari
        }
    };
    const campaignEl = document.querySelector("#campaign-performance-chart");
    if (campaignEl) {
        new ApexCharts(campaignEl, campaignOptions).render();
    }

    // 4. Ziyaret Aktiviteleri (Column Chart)
    const visitsOptions = {
        series: [{
            name: 'Ziyaret Sayısı',
            data: [5, 8, 12, 10, 15, 7, 4]
        }],
        chart: {
            height: 300,
            type: 'bar',
            toolbar: { show: false }
        },
        colors: ['#20c997'],
        plotOptions: {
            bar: { borderRadius: 4, columnWidth: '50%' }
        },
        xaxis: {
            categories: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar']
        }
    };
    const visitsEl = document.querySelector("#visits-activity-chart");
    if (visitsEl) {
        new ApexCharts(visitsEl, visitsOptions).render();
    }

});



if ($("#siparis_durumu_select").length>0) {
    $(document).ready(function() {
        $('#siparis_durumu_select').on('change', function() {
            if ($(this).val() == '2') { // Kargoya Verildi seçildiyse
                $('#kargo_bilgileri_alani').slideDown();
            } else {
                $('#kargo_bilgileri_alani').slideUp();
            }
        });
    });
}

if ($("#login").length > 0) {
    $('#login').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        let $form = $(this);
        if ($form.data('submitting')) return;
        $form.data('submitting', true);

        let formData = $form.serialize();
        if (!$form.find('input[name="csrf_token"]').val()) {
            formData += '&csrf_token=' + encodeURIComponent(
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            );
        }

        $.ajax({
            url: 'request/login',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $form.data('submitting', false);
                if (response.type === 'require_2fa') {
                    askSmsCode();
                } else if (response.type === 'error') {
                    Swal.fire('Hata', response.message, 'error');
                } else {
                    window.location.href = response.redirect || 'index';
                }
            },
            error: function() {
                $form.data('submitting', false);
                Swal.fire('Hata', 'Sunucu bağlantısı sırasında bir hata oluştu.', 'error');
            }
        });
    });

    function askSmsCode() {
        Swal.fire({
            title: 'SMS Doğrulama',
            text: 'Telefonunuza gelen 6 haneli doğrulama kodunu girin:',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
                maxlength: 6
            },
            showCancelButton: true,
            confirmButtonText: 'Doğrula',
            cancelButtonText: 'İptal',
            allowOutsideClick: false,
            preConfirm: (smsKodu) => {
                if (!smsKodu) {
                    Swal.showValidationMessage('Lütfen kodu boş bırakmayın!');
                    return false;
                }
                
                return $.ajax({
                    url: 'request/login',
                    type: 'POST',
                    data: {
                        sms_dogrulama_kodu: smsKodu,
                        csrf_token: $('input[name="csrf_token"]').val()
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.type === 'error' || response.code_error) {
                        Swal.showValidationMessage(response.message);
                        return false;
                    }
                    return response;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // PHP başarılı döndüğünde yönlendir
                window.location.href = result.value.redirect || 'index';
            }
        });
    }
}

// const idleLimitMinutes = 15;
// const idleLimitMs = idleLimitMinutes * 60 * 1000;
// let lastActivityTime = Date.now();

// function resetIdleTimer() {
//     lastActivityTime = Date.now();
// }

// const events = ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart', 'input', 'click'];
// events.forEach(eventName => {
//     window.addEventListener(eventName, resetIdleTimer, true);
// });

// const idleInterval = setInterval(function() {
//     let currentTime = Date.now();
//     let elapsedMs = currentTime - lastActivityTime;
    
//     if (elapsedMs >= idleLimitMs) {
//         clearInterval(idleInterval);
//         window.location.href = _url + "lock?reason=timeout";
//     }
// }, 10000);


document.addEventListener("DOMContentLoaded", function() {
    const posSecimi = document.getElementById("posSecimi");
    const paytrFields = document.getElementById("paytr-fields");
    const iyzicoFields = document.getElementById("iyzico-fields");
    const mokaFields = document.getElementById("moka-fields");

    function posGosterGizle() {
        if(!posSecimi) return;
        
        if(paytrFields) paytrFields.style.display = "none";
        if(iyzicoFields) iyzicoFields.style.display = "none";
        if(mokaFields) mokaFields.style.display = "none";

        if(posSecimi.value === "paytr") {
            if(paytrFields) paytrFields.style.display = "block";
        } else if(posSecimi.value === "iyzico") {
            if(iyzicoFields) iyzicoFields.style.display = "block";
        } else if(posSecimi.value === "moka") {
            if(mokaFields) mokaFields.style.display = "block";
        }
    }

    if(posSecimi) {
        posGosterGizle();
        posSecimi.addEventListener("change", posGosterGizle);
    }
});
document.addEventListener("click", function(e) {
    if (e.target.closest(".add-row-btn")) {
        const btn = e.target.closest(".add-row-btn");
        const container = document.querySelector(btn.dataset.target);
        const rows = container.querySelectorAll(".dynamic-row");
        
        if (rows.length > 0) {
            const lastRow = rows[rows.length - 1];
            const newRow = lastRow.cloneNode(true);
            
            newRow.querySelectorAll("input").forEach(input => input.value = "");
            newRow.querySelectorAll("select").forEach(select => select.selectedIndex = 0);
            
            container.appendChild(newRow);
            reindexRows(container);
        }
    }

    if (e.target.closest(".remove-row")) {
        const row = e.target.closest(".dynamic-row");
        const container = row.parentElement;
        if (container.querySelectorAll(".dynamic-row").length > 1) {
            row.remove();
            reindexRows(container);
        } else {
            alert("En az bir satır kalmalıdır.");
        }
    }

    if (e.target.closest(".move-up")) {
        const row = e.target.closest(".dynamic-row");
        const prevRow = row.previousElementSibling;
        if (prevRow) {
            row.parentNode.insertBefore(row, prevRow);
            reindexRows(row.parentElement);
        }
    }

    if (e.target.closest(".move-down")) {
        const row = e.target.closest(".dynamic-row");
        const nextRow = row.nextElementSibling;
        if (nextRow) {
            row.parentNode.insertBefore(nextRow, row);
            reindexRows(row.parentElement);
        }
    }
});

function reindexRows(container) {
    container.querySelectorAll(".dynamic-row").forEach((row, index) => {
        row.querySelectorAll("input, select").forEach(input => {
            let name = input.getAttribute("name");
            if (name) {
                name = name.replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute("name", name);
            }
        });
    });
}

if ($("#faqArama").length > 0) {
    document.getElementById('faqArama').addEventListener('keyup', function() {
        let aranan = this.value.toLowerCase();
        let faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(function(item) {
            let text = item.innerText.toLowerCase();
            if (text.includes(aranan)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

if ($("#galeriTipSelect").length > 0) {
    document.addEventListener("DOMContentLoaded", function() {
        const tipSelect = document.getElementById('galeriTipSelect');
        const videoContainer = document.getElementById('videoUrlContainer');

        function checkVideoType() {
            if (tipSelect.value === '2') {
                videoContainer.style.display = 'block';
            } else {
                videoContainer.style.display = 'none';
            }
        }

        tipSelect.addEventListener('change', checkVideoType);
        checkVideoType(); // Sayfa yüklendiğinde kontrol et
    });
}

if ($("#menuUrl").length > 0) {
    document.addEventListener("DOMContentLoaded", function() {
        const menuUrl = document.getElementById('menuUrl');
        const menuBaslik = document.getElementById('menuBaslik');

        const hizliSabit = document.getElementById('hizliSabit');
        const hizliSayfa = document.getElementById('hizliSayfa');
        const hizliKategori = document.getElementById('hizliKategori');
        const hizliUrun = document.getElementById('hizliUrun');

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function handleQuickSelect(selectedElement, otherElements) {
            if (selectedElement && selectedElement.value) {
                menuUrl.value = selectedElement.value;
                
                // Seçilen öğenin adını doğrudan menü başlığına yaz (Eski başlığı günceller)
                if (menuBaslik) {
                    menuBaslik.value = selectedElement.options[selectedElement.selectedIndex].text;
                }

                // Diğer hızlı seçim kutularını temizle
                otherElements.forEach(el => {
                    if (el) el.value = "";
                });
            }
        }

        if (hizliSabit) {
            hizliSabit.addEventListener('change', function() {
                handleQuickSelect(this, [hizliSayfa, hizliKategori, hizliUrun]);
            });
        }

        if (hizliSayfa) {
            hizliSayfa.addEventListener('change', function() {
                handleQuickSelect(this, [hizliSabit, hizliKategori, hizliUrun]);
            });
        }

        if (hizliKategori) {
            hizliKategori.addEventListener('change', function() {
                handleQuickSelect(this, [hizliSabit, hizliSayfa, hizliUrun]);
            });
        }

        if (hizliUrun) {
            hizliUrun.addEventListener('change', function() {
                handleQuickSelect(this, [hizliSabit, hizliSayfa, hizliKategori]);
            });
        }

        // Üst menü filtreleme
        const menuTipSelect = document.getElementById('menu_tip');
        const menuUstSelect = document.getElementById('menu_ust');

        if (menuTipSelect && menuUstSelect) {
            function loadUstMenuler(tip, selectedUstId = 0) {
                fetch('request/menus', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'postType=GetUstMenuler&menu_tip=' + encodeURIComponent(tip) + '&csrf_token=' + encodeURIComponent(csrfToken)
                })
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="0">Ana Menü Olsun</option>';
                    if (data && Array.isArray(data)) {
                        data.forEach(item => {
                            let sel = (item.menu_id == selectedUstId) ? 'selected' : '';
                            options += `<option value="${item.menu_id}" ${sel}>${item.menu_baslik}</option>`;
                        });
                    }
                    menuUstSelect.innerHTML = options;
                })
                .catch(err => console.error('Hata:', err));
            }

            menuTipSelect.addEventListener('change', function() {
                loadUstMenuler(this.value, 0);
            });
        }
    });
}

if ($("#yeniOzellikEkle").length > 0) {
    document.addEventListener("DOMContentLoaded", function() {
        // Galeri Sürükle-Bırak Sıralama
        var galleryGrid = document.getElementById('sortable-gallery');
        if(galleryGrid) {
            new Sortable(galleryGrid, {
                animation: 150,
                ghostClass: 'bg-light',
                handle: '.card-header',
                onEnd: function (evt) {
                    console.log("Galeri sıralaması güncellendi.");
                }
            });
        }

        // Dinamik Özellik / Soru Satır Ekleme
        const kapsayici = document.getElementById('ozelliklerKapsayici');
        const ekleBtn = document.getElementById('yeniOzellikEkle');

        function satirEkle(baslik = '', aciklama = '') {
            const div = document.createElement('div');
            div.className = 'row g-2 align-items-center border p-2 rounded bg-white shadow-sm';
            div.innerHTML = `
                <div class="col-xl-4">
                    <input type="text" class="form-control form-control-sm" name="ozellik_baslik[]" placeholder="Özellik Başlığı veya Soru" value="${baslik}">
                </div>
                <div class="col-xl-7">
                    <input type="text" class="form-control form-control-sm" name="ozellik_aciklama[]" placeholder="Açıklama veya Cevap" value="${aciklama}">
                </div>
                <div class="col-xl-1 text-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 satirSilBtn"><i class="bi bi-trash"></i></button>
                </div>
            `;
            kapsayici.appendChild(div);

            div.querySelector('.satirSilBtn').addEventListener('click', function() {
                div.remove();
            });
        }

        if(ekleBtn) {
            ekleBtn.addEventListener('click', function() {
                satirEkle();
            });
        }

        document.querySelectorAll('.satirSilBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                btn.closest('.row').remove();
            });
        });
    });
}

if ($(".select-all-column").length > 0) {
    document.addEventListener("DOMContentLoaded", function() {
        // Sütun başlıklarındaki "Tümünü Seç" kutuları için işlevsellik
        const selectAllCheckboxes = document.querySelectorAll('.select-all-column');

        selectAllCheckboxes.forEach(masterCheckbox => {
            masterCheckbox.addEventListener('change', function() {
                const permissionType = this.getAttribute('data-target');
                const isChecked = this.checked;

                // İlgili sütundaki tüm checkbox'ları bul ve ana kutunun durumuna göre ayarla
                const targetCheckboxes = document.querySelectorAll(`.permission-checkbox[data-permission="${permissionType}"]`);
                targetCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                });
            });
        });
    });
}