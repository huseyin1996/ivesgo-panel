<?php
if (!yetkisiVarMi("ayarlar", 'goruntule')) {
    header("Location:" . URL . "index");
}

// JSON verilerini PHP dizilerine dönüştürüyoruz
$modul         = json_decode($ayar['modul_ayarlari'] ?? '{}', true);
$seo           = json_decode($ayar['seo_ayarlari'] ?? '{}', true);
$iletisim_arr  = json_decode($ayar['site_iletisim'] ?? '[]', true);
$sosyal_arr    = json_decode($ayar['sosyal_medya'] ?? '[]', true);
$dil_arr       = json_decode($ayar['dil_ayarlari'] ?? '[]', true);
$tarihce_arr   = json_decode($ayar['tarihce'] ?? '[]', true);
$banka_arr     = json_decode($ayar['banka_bilgiler'] ?? '[]', true);
$mail          = json_decode($ayar['mail_ayarlari'] ?? '{}', true);
$sms           = json_decode($ayar['sms_ayarlari'] ?? '{}', true);
$api           = json_decode($ayar['api_ayarlari'] ?? '{}', true);
$pos           = json_decode($ayar['pos_ayarlari'] ?? '{}', true);
$sepet         = json_decode($ayar['sepet_ayarlari'] ?? '{}', true);
$tema_arr      = json_decode($ayar["tema_ayarlari"] ?? '{}', true);

?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Genel Sistem Ayarları</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Yönetim</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ayarlar</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <form class="postForm" action="request/settings" method="post" enctype="multipart/form-data">
            <input type="hidden" name="postType" value="Update">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

            <div class="row">
                <!-- SOL MENÜ SEKMELERİ -->
                <div class="col-xl-3">
                    <div class="card custom-card shadow-sm border-0">
                        <div class="card-body p-2">
                            <div class="nav nav-pills flex-column nav-style-6" id="settings-tab" role="tablist">
                                <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#genel" type="button"><i class="bi bi-gear me-2"></i> Genel & Bakım</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#moduller" type="button"><i class="bi bi-toggle-on me-2"></i> Modül Yönetimi</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#seo" type="button"><i class="bi bi-search me-2"></i> SEO Ayarları</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#tema_ayarlari" type="button"><i class="bi bi-palette me-2"></i> Tema & Entegrasyon Ayarları</button>
                                <?php if (modulAktifMi($db, 'sepet')): ?>
                                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#sepet_kargo" type="button"><i class="bi bi-cart me-2"></i> Sepet & Ödemeler</button>
                                <?php endif ?>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#iletisim" type="button"><i class="bi bi-geo-alt me-2"></i> İletişim Bilgileri</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#sosyal_medya" type="button"><i class="bi bi-share me-2"></i> Sosyal Medya</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#dil_ayarlari" type="button"><i class="bi bi-translate me-2"></i> Dil Sabitleri</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#tarihce" type="button"><i class="bi bi-translate me-2"></i> Tarihçe</button>
                                <?php if (modulAktifMi($db, 'sepet')): ?>
                                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#banka_hesaplari" type="button"><i class="bi bi-bank me-2"></i> Banka & IBAN</button>
                                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#pos_ayarlari" type="button"><i class="bi bi-credit-card me-2"></i> Sanal POS</button>
                                <?php endif ?>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#medya" type="button"><i class="bi bi-images me-2"></i> Logo & Görseller</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#mail_ayarlari" type="button"><i class="bi bi-envelope me-2"></i> Mail Ayarları</button>
                                <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#sms_ayarlari" type="button"><i class="bi bi-chat-dots me-2"></i> SMS Ayarları</button>
                                <?php if ($giris_cek['uye_rutbe'] == 1): ?>
                                    <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#api_ayarlari" type="button"><i class="bi bi-code-slash me-2"></i> API Entegrasyonları</button>
                                <?php endif ?>
                                <?php if (modulAktifMi($db, 'mail') && yetkisiVarMi("mail", 'goruntule')): ?>
                                    <a class="nav-link text-start" href="mail-adresleri"><i class="bi bi-at me-2"></i> Mail Adresleri</a>
                                <?php endif ?>
                                <a class="nav-link text-start" href="kullanim-kilavuzu-yonetimi"><i class="bi bi-chat-dots me-2"></i> Kullanma Klavuzu</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SAĞ İÇERİK ALANI -->
                <div class="col-xl-9">
                    <div class="card custom-card shadow-sm border-0">
                        <div class="card-body">
                            <div class="tab-content" id="settings-tabContent">
                                
                                <!-- 1. GENEL & BAKIM -->
                                <div class="tab-pane fade show active" id="genel" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Genel Sistem Ayarları</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold">Site Ana URL</label>
                                            <input type="text" class="form-control" name="site_url" value="<?=htmlspecialchars($ayar['site_url'] ?? '')?>" <?=($_SESSION['uye_id'] != 1 ? 'readonly' : '')?> required>
                                        </div>

                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold">API Token</label>
                                            <input type="text" class="form-control" name="api_token" value="<?=htmlspecialchars($ayar['api_token'] ?? '')?>" <?=($_SESSION['uye_id'] != 1 ? 'readonly' : '')?> required>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="card custom-card shadow-none border bg-light">
                                                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <label class="form-check-label fw-bold text-danger" for="bakimSwitch">Bakım Modunu Aktif Et (Site dış dünyaya kapanır)</label>
                                                    <div class="form-check form-check-md form-switch mb-0">
                                                        <input class="form-check-input" type="checkbox" role="switch" name="bakim_modu" value="1" id="bakimSwitch" <?=($ayar['bakim_modu']==1?'checked':'')?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="moduller" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Modül Aç / Kapat Yönetimi</h5>
                                    <div class="row gy-3">
                                        <?php 
                                        $modul_listesi = [
                                            'sms_bildirimleri'  => 'SMS Bildirim Servisi',
                                            'kampanya_kupon'    => 'Kampanya & Kupon Sistemi',
                                            'siparisler'        => 'Sipariş İşlemleri',
                                            'sepet'             => 'Sepet İşlemleri',
                                            'giris_dogrulama'   => 'Giriş 2 Aşamalı Doğrulama',
                                            'urunler'           => 'Ürün Yönetimi',
                                            'kategoriler'       => 'Kategori Yönetimi',
                                            'blog'              => 'Blog Yönetimi',
                                            'sayfa'             => 'Sayfa Yönetimi',
                                            'yorumlar'          => 'Müşteri Yorumları',
                                            'galeri'            => 'Galeri Yönetimi',
                                            'slider'            => 'Slider Yönetimi',
                                            'sss'               => 'Sıkça Sorulan Sorular (SSS)',
                                            'tarihce'           => 'Tarihçe Yönetimi',
                                            'iletisim'          => 'İletişim Yönetimi',
                                            'ekibimiz'          => 'Ekip Yönetimi',
                                            'menu'              => 'Menü Yönetimi',
                                            'sabit-sayfa'       => 'Sayfa Seo Yönetimi',
                                            'sabit-resim'       => 'Sabit Resim Yönetimi',
                                            'menu'              => 'Menü Yönetimi',
                                            'mail'              => 'Mail Yönetici',
                                            'bakim'             => 'Bakım Modu',
                                            'raporlar'          => 'Rapor Yönetimi'
                                        ];
                                        foreach($modul_listesi as $key => $baslik):
                                        ?>
                                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card custom-card shadow-none border">
                                                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <label class="form-check-label fw-medium" for="mod_<?=$key?>"><?=$baslik?></label>
                                                    <div class="form-check form-check-md form-switch mb-0">
                                                        <input class="form-check-input" type="checkbox" role="switch" name="modul[<?=$key?>]" value="1" id="mod_<?=$key?>" <?=((isset($modul[$key]) && $modul[$key]==1)?'checked':'')?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 3. SEO AYARLARI -->
                                <div class="tab-pane fade" id="seo" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Arama Motoru (SEO) Optimizasyonu</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold">Site Meta Başlığı (Title)</label>
                                            <input type="text" class="form-control" name="seo[title]" value="<?=htmlspecialchars($seo['title'] ?? '')?>">
                                        </div>
                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold">Site Meta Açıklaması (Description)</label>
                                            <textarea class="form-control" name="seo[description]" rows="2"><?=htmlspecialchars($seo['description'] ?? '')?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tema_ayarlari" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Tema, Renk, Canlı Destek ve Entegrasyon Yönetimi</h5>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold mb-2">CSS Root Renk ve Değişkenleri</label>
                                        <div id="css-container" class="vstack gap-2">
                                            <?php 
                                            $renkler_arr = $tema_arr['renkler'] ?? [];
                                            if(!empty($renkler_arr)){
                                                foreach($renkler_arr as $index => $cek){ ?>
                                                    <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                        <div class="col-xl-5">
                                                            <input type="text" class="form-control font-monospace" name="renkler[<?=$index?>][name]" <?=($_SESSION['uye_id'] != 1 ? 'readonly' : '')?> value="<?=$cek["name"]?>" placeholder="--primary-color">
                                                        </div>
                                                        <div class="col-xl-5">
                                                            <input type="text" class="form-control" name="renkler[<?=$index?>][value]" <?=($_SESSION['uye_id'] != 1 ? 'readonly' : '')?> value="<?=$cek["value"]?>" placeholder="#18304f">
                                                        </div>
                                                        <div class="col-xl-2 text-end">
                                                            <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#css-container"><i class="bi bi-plus-lg"></i></button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                    <div class="col-xl-5">
                                                        <input type="text" class="form-control font-monospace" name="renkler[0][name]" value="--primary-color" placeholder="--primary-color">
                                                    </div>
                                                    <div class="col-xl-5">
                                                        <input type="text" class="form-control" name="renkler[0][value]" value="#18304f" placeholder="#18304f">
                                                    </div>
                                                    <div class="col-xl-2 text-end">
                                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#css-container"><i class="bi bi-plus-lg"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <?php 
                                    $tema_cek = $tema_arr["tema_ayar"] ?? [];
                                    ?>

                                    <h5 class="fw-bold mb-3">Harici Servis ve Entegrasyon ID / Kodları</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold">Google Font URL</label>
                                            <input type="text" class="form-control" name="tema_ayar[fonts_url]" placeholder="https://fonts.googleapis.com/css2?family=..." value="<?=htmlspecialchars($tema_cek["fonts_url"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Analytics ID / Kodu</label>
                                            <input type="text" class="form-control" name="tema_ayar[analytics]" placeholder="G-XXXXXXXXXX" value="<?=htmlspecialchars($tema_cek["analytics"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Site Verification</label>
                                            <input type="text" class="form-control" name="tema_ayar[verification]" placeholder="Doğrulama kodu" value="<?=htmlspecialchars($tema_cek["verification"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Tag Manager ID</label>
                                            <input type="text" class="form-control" name="tema_ayar[tag_manager]" placeholder="GTM-XXXXXXX" value="<?=htmlspecialchars($tema_cek["tag_manager"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Facebook / Meta Pixel ID</label>
                                            <input type="text" class="form-control" name="tema_ayar[facebook_pixel]" placeholder="Pixel ID" value="<?=htmlspecialchars($tema_cek["facebook_pixel"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">LinkedIn Partner ID / Insight Tag</label>
                                            <input type="text" class="form-control" name="tema_ayar[linkedin_partner_id]" placeholder="Partner ID veya Kod" value="<?=htmlspecialchars($tema_cek["linkedin_partner_id"] ?? '')?>">
                                        </div>


                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Recaptcha Site Key</label>
                                            <input type="text" class="form-control" name="tema_ayar[captcha]" placeholder="Site Key" value="<?=htmlspecialchars($tema_cek["captcha"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Recaptcha Secret Key</label>
                                            <input type="text" class="form-control" name="tema_ayar[captchaKey]" placeholder="Secret Key" value="<?=htmlspecialchars($tema_cek["captchaKey"] ?? '')?>">
                                        </div>

                                        <div class="col-xl-12"><hr class="my-2"><h5 class="fw-bold mb-3">Google Analytics (GA4) Canlı Veri API Entegrasyonu</h5></div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">GA4 Mülk ID (Property ID)</label>
                                            <input type="text" class="form-control" name="tema_ayar[ga_property_id]" placeholder="Örn: 384920192" value="<?=htmlspecialchars($tema_cek["ga_property_id"] ?? '')?>">
                                            <small class="text-muted">Anasayfadaki grafik ve istatistiklerin veri çekeceği 9 haneli GA4 Mülk ID'niz.</small>
                                        </div>

                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Google Servis Hesabı JSON Anahtar Dosyası</label>
                                            <input type="file" class="form-control form-control-sm py-0 ps-2" name="google_key_json" accept=".json">
                                            <small class="text-muted text-danger">Sadece geçerli `.json` uzantılı Google servis hesabı anahtarları kabul edilir.</small>
                                            
                                            <?php if(!empty($tema_cek['google_key_file'])): ?>
                                                <div class="mt-2 text-success small"><i class="bi bi-check-circle-fill me-1"></i> Yüklü Dosya: <?=htmlspecialchars($tema_cek['google_key_file'])?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-xl-12"><hr class="my-2"><h5 class="fw-bold mb-3">Canlı Destek ve İletişim Entegrasyon ID'leri</h5></div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Tawk.to Property ID</label>
                                            <input type="text" class="form-control" name="tema_ayar[tawk_id]" placeholder="Örn: 6052b... / 5f..." value="<?=htmlspecialchars($tema_cek["tawk_id"] ?? '')?>">
                                            <small class="text-muted">Sadece tawk.to mülk ID numaranızı giriniz.</small>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Crisp Website ID</label>
                                            <input type="text" class="form-control" name="tema_ayar[crisp_id]" placeholder="Örn: xxxxxxxx-xxxx-..." value="<?=htmlspecialchars($tema_cek["crisp_id"] ?? '')?>">
                                            <small class="text-muted">Sadece crisp web sitesi UUID anahtarını giriniz.</small>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">WhatsApp Destek Hattı (Telefon)</label>
                                            <input type="text" class="form-control" name="tema_ayar[whatsapp_tel]" placeholder="905320000000" value="<?=htmlspecialchars($tema_cek["whatsapp_tel"] ?? '')?>">
                                            <small class="text-muted">Başında '+' olmadan ülke koduyla birlikte yazınız.</small>
                                        </div>

                                        <div class="col-xl-12"><hr class="my-2"></div>

                                        <!-- 3. BAKIM MODU VE DİNAMİK TARİH YÖNETİMİ -->
                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold text-danger">Bakım Modu (Yapım Aşamasında)</label>
                                            <select name="tema_ayar[site_durum]" id="bakimModuSelect" class="form-select">
                                                <option value="1" <?=($tema_cek["site_durum"] ?? 1) == 1 ? "selected" : ""?>>Kapalı (Site Yayında)</option>
                                                <option value="0" <?=($tema_cek["site_durum"] ?? 1) == 0 ? "selected" : ""?>>Açık (Bakım Ekranı Aktif)</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-6" id="bakimTarihAlani" style="<?=($tema_cek["site_durum"] ?? 1) == 1 ? 'display:none;' : ''?>">
                                            <label class="form-label fw-bold text-danger">Yeniden Açılış / Bitiş Tarihi</label>
                                            <input type="datetime-local" class="form-control" name="tema_ayar[bakim_bitis_tarihi]" value="<?=htmlspecialchars($tema_cek["bakim_bitis_tarihi"] ?? date('Y-m-d\TH:i'))?>">
                                            <small class="text-muted">Ziyaretçilere gösterilecek tahmini açılış zamanı.</small>
                                        </div>

                                        <div class="col-xl-12"><hr class="my-2"></div>

                                        <!-- 4. TASARIM VE GÖRÜNÜM SEÇENEKLERİ -->
                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Header Top Bar Tasarımı</label>
                                            <select name="tema_ayar[topbar]" class="form-select">
                                                <option value="1" <?=($tema_cek["topbar"] ?? '') == "1" ? "selected" : ""?>>Siyah</option>
                                                <option value="2" <?=($tema_cek["topbar"] ?? '') == "2" ? "selected" : ""?>>Beyaz</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Anasayfa Slider Tasarım</label>
                                            <select name="tema_ayar[slider]" class="form-select">
                                                <option value="1" <?=($tema_cek["slider"] ?? '') == "1" ? "selected" : ""?>>Tasarım 1</option>
                                                <option value="2" <?=($tema_cek["slider"] ?? '') == "2" ? "selected" : ""?>>Tasarım 2</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Anasayfa Hakkımızda</label>
                                            <select name="tema_ayar[about]" class="form-select">
                                                <option value="1" <?=($tema_cek["about"] ?? '') == "1" ? "selected" : ""?>>Tasarım 1</option>
                                                <option value="2" <?=($tema_cek["about"] ?? '') == "2" ? "selected" : ""?>>Tasarım 2</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Açılış Popup Durumu</label>
                                            <select name="tema_ayar[popup]" class="form-select">
                                                <option value="0" <?=($tema_cek["popup"] ?? '') == "0" ? "selected" : ""?>>Kapalı</option>
                                                <option value="1" <?=($tema_cek["popup"] ?? '') == "1" ? "selected" : ""?>>Form Popup</option>
                                                <option value="2" <?=($tema_cek["popup"] ?? '') == "2" ? "selected" : ""?>>Resim Popup</option>
                                                <option value="3" <?=($tema_cek["popup"] ?? '') == "3" ? "selected" : ""?>>YouTube Video Popup</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Cookie (Çerez) Uyarısı</label>
                                            <select name="tema_ayar[cookie]" class="form-select">
                                                <option value="0" <?=($tema_cek["cookie"] ?? '') == "0" ? "selected" : ""?>>Kapalı</option>
                                                <option value="1" <?=($tema_cek["cookie"] ?? '') == "1" ? "selected" : ""?>>Açık</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-4">
                                            <label class="form-label fw-bold">Dil Gösterimi</label>
                                            <select name="tema_ayar[lang]" class="form-select">
                                                <option value="0" <?=($tema_cek["lang"] ?? '') == "0" ? "selected" : ""?>>Gizle</option>
                                                <option value="1" <?=($tema_cek["lang"] ?? '') == "1" ? "selected" : ""?>>Göster</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                // Bakım modu açıldığında tarih alanını gösteren pratik JS kontrolü
                                document.addEventListener("DOMContentLoaded", function() {
                                    const bakimSelect = document.getElementById("bakimModuSelect");
                                    const tarihAlani = document.getElementById("bakimTarihAlani");
                                    
                                    if(bakimSelect && tarihAlani) {
                                        bakimSelect.addEventListener("change", function() {
                                            if(this.value === "0") {
                                                tarihAlani.style.display = "block";
                                            } else {
                                                tarihAlani.style.display = "none";
                                            }
                                        });
                                    }
                                });
                                </script>

                                <!-- 4. SEPET & ÖDEMELER -->
                                <div class="tab-pane fade" id="sepet_kargo" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Sepet, Kargo ve Aktif Ödeme Yöntemleri</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Minimum Sepet Tutarı (Ücretsiz Kargo Limiti)</label>
                                            <input type="number" step="0.01" class="form-control" name="sepet[min_sepet]" value="<?=$sepet['min_sepet'] ?? 0?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">Standart Kargo Ücreti (₺)</label>
                                            <input type="number" step="0.01" class="form-control" name="sepet[kargo_ucret]" value="<?=$sepet['kargo_ucret'] ?? 0?>">
                                        </div>
                                        <div class="col-xl-12 mt-3">
                                            <h6 class="fw-bold mb-2">Sitede Aktif Edilecek Ödeme Yöntemleri</h6>
                                            <div class="row g-2">
                                                <?php 
                                                $odemeler = ['kredi_karti' => 'Kredi Kartı (Sanal POS)', 'havale_eft' => 'Havale / EFT', 'kapida_odeme' => 'Kapıda Ödeme'];
                                                foreach($odemeler as $okey => $oval):
                                                ?>
                                                <div class="col-xl-4">
                                                    <div class="card custom-card shadow-none border">
                                                        <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                            <label class="form-check-label fs-13" for="ode_<?=$okey?>"><?=$oval?></label>
                                                            <div class="form-check form-check-md form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" name="sepet[aktif_odemeler][<?=$okey?>]" value="1" id="ode_<?=$okey?>" <?=((isset($sepet['aktif_odemeler'][$okey]) && $sepet['aktif_odemeler'][$okey]==1)?'checked':'')?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5. İLETİŞİM BİLGİLERİ -->
                                <div class="tab-pane fade" id="iletisim" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <h5 class="fw-bold mb-0">İletişim Bilgileri</h5>
                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#iletisim-container"><i class="bi bi-plus-lg me-1"></i> Yeni Ekle</button>
                                    </div>
                                    <div id="iletisim-container" class="vstack gap-3">
                                        <?php if(empty($iletisim_arr)): $iletisim_arr = [['tip' => 1, 'value' => '']]; endif; ?>
                                        <?php foreach($iletisim_arr as $index => $cek): ?>
                                            <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                <div class="col-xl-4">
                                                    <select class="form-select" name="iletisim[<?=$index?>][tip]">
                                                        <option <?=($cek["tip"] == 1) ? "selected" : ""?> value="1">Telefon</option>
                                                        <option <?=($cek["tip"] == 2) ? "selected" : ""?> value="2">Email</option>
                                                        <option <?=($cek["tip"] == 3) ? "selected" : ""?> value="3">Adres</option>
                                                        <option <?=($cek["tip"] == 4) ? "selected" : ""?> value="4">Gsm</option>
                                                        <option <?=($cek["tip"] == 5) ? "selected" : ""?> value="5">Whatsapp</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-6">
                                                    <input class="form-control" type="text" name="iletisim[<?=$index?>][value]" value="<?=htmlspecialchars($cek["value"] ?? '')?>" placeholder="Değer">
                                                </div>
                                                <div class="col-xl-2 text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-up" title="Yukarı"><i class="bi bi-arrow-up"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-down" title="Aşağı"><i class="bi bi-arrow-down"></i></button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Sil"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 6. SOSYAL MEDYA -->
                                <div class="tab-pane fade" id="sosyal_medya" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <h5 class="fw-bold mb-0">Sosyal Medya Hesapları</h5>
                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#sosyal-container"><i class="bi bi-plus-lg me-1"></i> Yeni Ekle</button>
                                    </div>
                                    <div id="sosyal-container" class="vstack gap-3">
                                        <?php if(empty($sosyal_arr)): $sosyal_arr = [['platform' => 'Instagram', 'url' => '']]; endif; ?>
                                        <?php foreach($sosyal_arr as $index => $item): ?>
                                            <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                <div class="col-xl-4">
                                                    <select class="form-select" name="sosyal[<?=$index?>][platform]">
                                                        <option value="Instagram" <?=($item['platform']=='Instagram'?'selected':'')?>>Instagram</option>
                                                        <option value="Facebook" <?=($item['platform']=='Facebook'?'selected':'')?>>Facebook</option>
                                                        <option value="LinkedIn" <?=($item['platform']=='LinkedIn'?'selected':'')?>>LinkedIn</option>
                                                        <option value="Twitter / X" <?=($item['platform']=='Twitter / X'?'selected':'')?>>Twitter / X</option>
                                                        <option value="YouTube" <?=($item['platform']=='YouTube'?'selected':'')?>>YouTube</option>
                                                        <option value="TikTok" <?=($item['platform']=='TikTok'?'selected':'')?>>TikTok</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="text" class="form-control" name="sosyal[<?=$index?>][url]" value="<?=htmlspecialchars($item['url'] ?? '')?>" placeholder="Profil URL Linki">
                                                </div>
                                                <div class="col-xl-2 text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-up" title="Yukarı"><i class="bi bi-arrow-up"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-down" title="Aşağı"><i class="bi bi-arrow-down"></i></button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Sil"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 7. DİL SABİTLERİ -->
                                <div class="tab-pane fade" id="dil_ayarlari" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <h5 class="fw-bold mb-0">Sabit Dil / Blok Kelimeleri</h5>
                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#dil-container"><i class="bi bi-plus-lg me-1"></i> Yeni Kelime</button>
                                    </div>
                                    <div id="dil-container" class="vstack gap-3">
                                        <?php if(empty($dil_arr)): $dil_arr = [['title' => 'sepete_ekle', 'value' => 'Sepete Ekle']]; endif; ?>
                                        <?php foreach($dil_arr as $index => $item): ?>
                                            <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                <div class="col-xl-4">
                                                    <input type="text" class="form-control font-monospace" name="dil[<?=$index?>][title]" value="<?=htmlspecialchars($item["title"] ?? '')?>" placeholder="Anahtar">
                                                </div>
                                                <div class="col-xl-6">
                                                    <input type="text" class="form-control" name="dil[<?=$index?>][value]" value="<?=htmlspecialchars(strip_tags($item["value"] ?? ''))?>" placeholder="Metin">
                                                </div>
                                                <div class="col-xl-2 text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-up" title="Yukarı"><i class="bi bi-arrow-up"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-down" title="Aşağı"><i class="bi bi-arrow-down"></i></button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Sil"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tarihce" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <h5 class="fw-bold mb-0">Firma Tarihçesi</h5>
                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#tarihce-container"><i class="bi bi-plus-lg me-1"></i> Yeni Satır</button>
                                    </div>
                                    <div id="tarihce-container" class="vstack gap-3">
                                        <?php if(empty($tarihce_arr)): $tarihce_arr = [['yil' => '2026', 'aciklama' => 'Kuruluş ve Faaliyet Başlangıcı']]; endif; ?>
                                        <?php foreach($tarihce_arr as $index => $item): ?>
                                            <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                <div class="col-xl-2">
                                                    <input type="text" class="form-control font-monospace" name="tarihce[<?=$index?>][yil]" value="<?=htmlspecialchars($item["yil"] ?? '')?>" placeholder="Yıl (Örn: 2026)">
                                                </div>
                                                <div class="col-xl-4">
                                                    <input type="text" class="form-control" name="tarihce[<?=$index?>][baslik]" value="<?=htmlspecialchars(strip_tags($item["baslik"] ?? ''))?>" placeholder="Tarihçe Başlığı">
                                                </div>
                                                <div class="col-xl-4">
                                                    <input type="text" class="form-control" name="tarihce[<?=$index?>][aciklama]" value="<?=htmlspecialchars(strip_tags($item["aciklama"] ?? ''))?>" placeholder="Tarihçe Açıklaması">
                                                </div>
                                                <!-- Butonlar -->
                                                <div class="col-xl-2 text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-up" title="Yukarı"><i class="bi bi-arrow-up"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-down" title="Aşağı"><i class="bi bi-arrow-down"></i></button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Sil"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 8. BANKA & IBAN -->
                                <div class="tab-pane fade" id="banka_hesaplari" role="tabpanel">
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <h5 class="fw-bold mb-0">Banka Hesapları</h5>
                                        <button type="button" class="btn btn-sm btn-success add-row-btn" data-target="#banka-container"><i class="bi bi-plus-lg me-1"></i> Banka Ekle</button>
                                    </div>
                                    <div id="banka-container" class="vstack gap-3">
                                        <?php if(empty($banka_arr)): $banka_arr = [['banka' => 'garanti', 'sube' => '', 'para_birim' => 'TRY', 'hesap_no' => '', 'iban' => '']]; endif; ?>
                                        <?php foreach($banka_arr as $index => $cek): ?>
                                            <div class="row align-items-center dynamic-row g-2 p-2 bg-light border rounded">
                                                <div class="col-xl-3">
                                                    <select class="form-select" name="banka[<?=$index?>][banka]">
                                                        <option <?=($cek['banka'] == "akbank") ? "selected" : ""?> value="akbank">Akbank</option>
                                                        <option <?=($cek['banka'] == "albaraka") ? "selected" : ""?> value="albaraka">Albaraka</option>
                                                        <option <?=($cek['banka'] == "burgan") ? "selected" : ""?> value="burgan">Burgan</option>
                                                        <option <?=($cek['banka'] == "denizbank") ? "selected" : ""?> value="denizbank">Denizbank</option>
                                                        <option <?=($cek['banka'] == "finansbank") ? "selected" : ""?> value="finansbank">Finansbank</option>
                                                        <option <?=($cek['banka'] == "garanti") ? "selected" : ""?> value="garanti">Garanti BBVA</option>
                                                        <option <?=($cek['banka'] == "halkbank") ? "selected" : ""?> value="halkbank">Halkbank</option>
                                                        <option <?=($cek['banka'] == "ing") ? "selected" : ""?> value="ing">ING Bank</option>
                                                        <option <?=($cek['banka'] == "is-bank") ? "selected" : ""?> value="is-bank">İş Bank</option>
                                                        <option <?=($cek['banka'] == "kuveyt-türk") ? "selected" : ""?> value="kuveyt-türk">Kuveyt Türk</option>
                                                        <option <?=($cek['banka'] == "teb") ? "selected" : ""?> value="teb">TEB</option>
                                                        <option <?=($cek['banka'] == "turkiye-finans") ? "selected" : ""?> value="turkiye-finans">Türkiye Finans</option>
                                                        <option <?=($cek['banka'] == "vakif-bank") ? "selected" : ""?> value="vakif-bank">Vakıf Bank</option>
                                                        <option <?=($cek['banka'] == "yapi-kredi") ? "selected" : ""?> value="yapi-kredi">Yapı Kredi</option>
                                                        <option <?=($cek['banka'] == "ziraat") ? "selected" : ""?> value="ziraat">Ziraat Bank</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-2">
                                                    <input class="form-control" type="text" name="banka[<?=$index?>][para_birim]" value="<?=$cek['para_birim'] ?? 'TRY'?>" placeholder="Birim">
                                                </div>
                                                <div class="col-xl-5">
                                                    <input class="form-control" type="text" name="banka[<?=$index?>][iban]" value="<?=$cek['iban'] ?? ''?>" placeholder="TR00 0000 ...">
                                                </div>
                                                <div class="col-xl-2 text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-up" title="Yukarı"><i class="bi bi-arrow-up"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm move-down" title="Aşağı"><i class="bi bi-arrow-down"></i></button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Sil"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 9. SANAL POS -->
                                <div class="tab-pane fade" id="pos_ayarlari" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Sanal POS Entegrasyonları ve Güvenlik</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label class="form-label fw-bold text-primary">Aktif POS Sağlayıcı</label>
                                            <select class="form-select" name="pos[aktif_pos]" id="posSecimi">
                                                <option value="0" <?=($pos['aktif_pos']=='paytr'?'selected':'')?>>Pos Kapalı</option>
                                                <option value="paytr" <?=($pos['aktif_pos']=='paytr'?'selected':'')?>>PayTR</option>
                                                <option value="iyzico" <?=($pos['aktif_pos']=='iyzico'?'selected':'')?>>İyzico</option>
                                                <option value="moka" <?=($pos['aktif_pos']=='moka'?'selected':'')?>>Moka</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-12"><hr></div>
                                        
                                        <div class="col-xl-12 pos-fields" id="paytr-fields">
                                            <h6 class="fw-bold text-dark">PayTR Bilgileri (3 Parametre)</h6>
                                            <div class="row g-3 mt-1">
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Merchant ID</label>
                                                    <input type="text" class="form-control" name="pos[paytr][merchant_id]" value="<?=$pos['paytr']['merchant_id'] ?? ''?>">
                                                </div>
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Merchant Key (Şifreli)</label>
                                                    <input type="password" class="form-control" name="pos[paytr][merchant_key]" value="<?=$pos['paytr']['merchant_key'] ?? ''?>">
                                                </div>
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Merchant Salt (Şifreli)</label>
                                                    <input type="password" class="form-control" name="pos[paytr][merchant_salt]" value="<?=$pos['paytr']['merchant_salt'] ?? ''?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 pos-fields" id="iyzico-fields" style="display:none;">
                                            <h6 class="fw-bold text-dark">İyzico Bilgileri (2 Parametre)</h6>
                                            <div class="row g-3 mt-1">
                                                <div class="col-xl-6">
                                                    <label class="form-label small">API Key</label>
                                                    <input type="text" class="form-control" name="pos[iyzico][api_key]" value="<?=$pos['iyzico']['api_key'] ?? ''?>">
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label small">Secret Key (Şifreli)</label>
                                                    <input type="password" class="form-control" name="pos[iyzico][secret_key]" value="<?=$pos['iyzico']['secret_key'] ?? ''?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 pos-fields" id="moka-fields" style="display:none;">
                                            <h6 class="fw-bold text-dark">Moka Bilgileri (3 Parametre)</h6>
                                            <div class="row g-3 mt-1">
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Moka ID</label>
                                                    <input type="text" class="form-control" name="pos[moka][moka_id]" value="<?=$pos['moka']['moka_id'] ?? ''?>">
                                                </div>
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Moka USERNAME</label>
                                                    <input type="text" class="form-control" name="pos[moka][moka_username]" value="<?=$pos['moka']['moka_username'] ?? ''?>">
                                                </div>
                                                <div class="col-xl-4">
                                                    <label class="form-label small">Moka Password</label>
                                                    <input type="password" class="form-control" name="pos[moka][moka_password]" value="<?=$pos['moka']['moka_password'] ?? ''?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 10. LOGO & GÖRSELLER -->
                                <div class="tab-pane fade" id="medya" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Kurumsal Görseller ve Medya</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label fw-bold">Site Logo</label>
                                            <input type="file" class="form-control" name="logo_file" accept="image/*">
                                            <?php if (resimVarmi('logo/', $ayar['logo'])): ?>
                                                <img src="<?=resimGetir('logo/', $ayar['logo'])?>" alt="Resim">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label fw-bold">Koyu Logosu</label>
                                            <input type="file" class="form-control" name="koyu_logo" accept="image/*">
                                            <?php if (resimVarmi('logo/', $ayar['koyu_logo'])): ?>
                                                <img src="<?=resimGetir('logo/', $ayar['koyu_logo'])?>" alt="Resim">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label fw-bold">Favicon</label>
                                            <input type="file" class="form-control" name="favicon_file" accept="image/*">
                                            <?php if (resimVarmi('favicon/', $ayar['favicon'])): ?>
                                                <img src="<?=resimGetir('favicon/', $ayar['favicon'])?>" alt="Resim">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-12 mt-3">
                                            <label class="form-label fw-bold">Giriş Sayfası Arka Planı (giris_resim)</label>
                                            <input type="file" class="form-control" name="giris_resim_file" accept="image/*">
                                            <?php if (resimVarmi('system/', $ayar['giris_resim'])): ?>
                                                <img src="<?=resimGetir('system/', $ayar['giris_resim'])?>" alt="Resim">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-12 mt-3">
                                            <label class="form-label fw-bold">Kampanya Popup Görseli (popup_resim)</label>
                                            <input type="file" class="form-control" name="popup_resim_file" accept="image/*">
                                            <?php if (resimVarmi('system/', $ayar['popup_resim'])): ?>
                                                <img src="<?=resimGetir('system/', $ayar['popup_resim'])?>" alt="Resim">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-12 mt-3">
                                            <label class="form-label fw-bold">Google Maps Embed Konum Kodu (iframe)</label>
                                            <textarea class="form-control" name="google_maps" rows="2" placeholder="<iframe src=...></iframe>"><?=htmlspecialchars($ayar['google_maps'] ?? '')?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- 11. MAIL AYARLARI -->
                                <div class="tab-pane fade" id="mail_ayarlari" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">SMTP Mail Gönderim Ayarları</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <label class="form-label">SMTP Sunucu (Host)</label>
                                            <input type="text" class="form-control" name="mail[host]" value="<?=$mail['host'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">SMTP Port</label>
                                            <input type="text" class="form-control" name="mail[port]" value="<?=$mail['port'] ?? '587'?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Gönderici E-Posta (User)</label>
                                            <input type="text" class="form-control" name="mail[user]" value="<?=$mail['user'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">SMTP Şifre</label>
                                            <input type="password" class="form-control" name="mail[pass]" value="<?=$mail['pass'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Alıcı / Bildirim E-Posta Adresi</label>
                                            <input type="email" class="form-control" name="mail[alici]" value="<?=$mail['alici'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Gönderici Görünen İsim</label>
                                            <input type="text" class="form-control" name="mail[isim]" value="<?=$mail['isim'] ?? ''?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- 12. SMS AYARLARI -->
                                <div class="tab-pane fade" id="sms_ayarlari" role="tabpanel">
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">SMS Entegrasyon Ayarları</h5>
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <label class="form-label fw-bold">SMS Sağlayıcı Firma</label>
                                            <select class="form-select" name="sms[firma]">
                                                <option value="0" <?=($sms['firma']=='0'?'selected':'')?>>Kapalı</option>
                                                <option value="netgsm" <?=($sms['firma']=='netgsm'?'selected':'')?>>Netgsm</option>
                                                <option value="iletimerkezi" <?=($sms['firma']=='iletimerkezi'?'selected':'')?>>İleti Merkezi</option>
                                                <option value="mutlucell" <?=($sms['firma']=='mutlucell'?'selected':'')?>>Mutlucell</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">API Kullanıcı Adı / Telefon</label>
                                            <input type="text" class="form-control" name="sms[kullanici]" value="<?=$sms['kullanici'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">API Şifresi</label>
                                            <input type="password" class="form-control" name="sms[sifre]" value="<?=$sms['sifre'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">SMS Başlığı (Originator)</label>
                                            <input type="text" class="form-control" name="sms[baslik]" value="<?=$sms['baslik'] ?? ''?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if ($giris_cek['uye_rutbe'] == 1): ?>
                                    <!-- 13. API ENTEGRASYONLARI -->
                                    <div class="tab-pane fade" id="api_ayarlari" role="tabpanel">
                                        <h5 class="fw-bold mb-3 pb-2 border-bottom">Harici API Bağlantı Ayarları</h5>
                                        <p class="text-muted">Bu alan harici servis entegrasyonları için ayrılmıştır.</p>
                                        
                                        <div class="row gy-4">
                                            <div class="col-xl-12">
                                                <div class="card custom-card shadow-none border bg-light">
                                                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                        <label class="form-check-label fw-bold" for="apiTypeSwitch">Genel API Erişimi / Aktiflik Durumu</label>
                                                        <div class="form-check form-check-md form-switch mb-0">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="api[api_type]" value="1" id="apiTypeSwitch" <?=((isset($api['api_type']) && $api['api_type']==1)?'checked':'')?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="card custom-card shadow-sm border">
                                                    <div class="card-header bg-white d-flex align-items-center justify-content-between">
                                                        <div class="card-title fw-bold m-0"><i class="ri-whatsapp-line me-1 text-success"></i> WhatsApp Cloud API Ayarları</div>
                                                        <div class="form-check form-switch mb-0">
                                                            <input class="form-check-input api-switch" type="checkbox" role="switch" name="api[whatsapp][durum]" value="1" id="waDurum" data-target="waFieldsContainer"<?=((isset($api['whatsapp']['durum']) && $api['whatsapp']['durum'] == 1) ? 'checked' : '')?>>
                                                            <label class="form-check-label small fw-semibold" for="waDurum">Aktif Et</label>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" id="waFieldsContainer">
                                                        <div class="row g-3">
                                                            <div class="col-xl-6">
                                                                <label class="form-label small fw-semibold">Phone Number ID (Telefon ID)</label>
                                                                <input type="text" class="form-control" name="api[whatsapp][phone_number_id]" value="<?=$api['whatsapp']['phone_number_id'] ?? ''?>">
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label small fw-semibold">Permanent Access Token (Erişim Jetonu)</label>
                                                                <input type="password" class="form-control" name="api[whatsapp][access_token]" value="<?=$api['whatsapp']['access_token'] ?? ''?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>

                            <?php if (yetkisiVarMi("ayarlar", 'duzenle')): ?>
                                <div class="mt-4 pt-3 border-top text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-bold">
                                        <i class="bi bi-check2-all me-1"></i> Tüm Ayarları Kaydet
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="mt-4 pt-3 border-top text-end text-danger">Güncelleme Yetkiniz Bulunmamaktadır.</div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Kamera Seçim Alanlarını Yönetme
        const camRadios = document.querySelectorAll(".kamera-radio");
        function updateCamVisibility() {
            document.querySelectorAll(".cam-field-group").forEach(el => el.style.display = "none");
            const checkedRadio = document.querySelector(".kamera-radio:checked");
            if (checkedRadio) {
                const targetFields = document.getElementById("fields-" + checkedRadio.value);
                if (targetFields) targetFields.style.display = "block";
            }
        }
        camRadios.forEach(radio => radio.addEventListener("change", updateCamVisibility));

        // API Switch Yönetimi
        const switches = document.querySelectorAll(".api-switch");
        function updateModuleState(sw, isInit = false) {
            const targetId = sw.getAttribute("data-target");
            const container = document.getElementById(targetId);
            if (!container) return;

            const formElements = container.querySelectorAll("input, select, textarea");
            if (!sw.checked) {
                container.style.opacity = "0.4";
                container.style.pointerEvents = "none";
                formElements.forEach(function(el) {
                    el.disabled = true;
                    if (!isInit) {
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            el.checked = false;
                        } else {
                            el.value = '';
                        }
                    }
                });
            } else {
                container.style.opacity = "1";
                container.style.pointerEvents = "auto";
                formElements.forEach(function(el) {
                    el.disabled = false;
                });
            }
        }

        switches.forEach(function(sw) {
            updateModuleState(sw, true);
            sw.addEventListener("change", function() {
                updateModuleState(this, false);
            });
        });
    });

    function kopyalaYaml() {
        const copyText = document.getElementById("yamlPreviewBox");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value).then(() => {
            alert("go2rtc.yaml içeriği panoya kopyalandı!");
        });
    }
</script>

