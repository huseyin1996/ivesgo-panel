<?php

if (!modulAktifMi($db, 'sayfa') && !yetkisiVarMi("sayfalar", 'ekle')) {
    header("Location:" . URL . "index");
    exit;
}

$sayfa_id = intval($par[1] ?? 0);
$sorgu = $db->prepare("SELECT * FROM i_sayfalar WHERE sayfa_id = ?");
$sorgu->execute([$sayfa_id]);
$cek = $sorgu->fetch(PDO::FETCH_ASSOC);

if(!$cek) {
    header("Location: " . URL . "sayfalar");
    exit;
}

$galeri_sorgu = $db->prepare("SELECT id, resim FROM i_sayfa_resimler WHERE sayfa_id = :id ORDER BY sira ASC, id ASC");
$galeri_sorgu->execute(['id' => $cek['sayfa_id']]);
$galeri_resimleri = $galeri_sorgu->fetchAll(PDO::FETCH_ASSOC);

$mevcutOzellikler = !empty($cek['sayfa_ozellikler']) ? json_decode($cek['sayfa_ozellikler'], true) : [];
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Sayfalar</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="sayfalar/">Sayfalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sayfa Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Sayfa Düzenle: <b><?=htmlspecialchars($cek['sayfa_baslik'])?></b>
                        </div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <form class="postForm needs-validation" action="request/pages" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['sayfa_id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <!-- Sekmeler (Tabs) -->
                            <ul class="nav nav-tabs mb-4 border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-bold px-4" id="temel-tab" data-bs-toggle="tab" data-bs-target="#temel-pane" type="button" role="tab">
                                        <i class="bi bi-file-earmark-text me-2"></i> Temel & İçerik
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="ozellik-tab" data-bs-toggle="tab" data-bs-target="#ozellik-pane" type="button" role="tab">
                                        <i class="bi bi-list-check me-2"></i> Özellikler / Soru-Cevap
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="medya-tab" data-bs-toggle="tab" data-bs-target="#medya-pane" type="button" role="tab">
                                        <i class="bi bi-images me-2"></i> Görseller & Galeri
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-pane" type="button" role="tab">
                                        <i class="bi bi-search me-2"></i> SEO & Görünürlük
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                
                                <!-- Tab 1: Temel & İçerik -->
                                <div class="tab-pane fade p-0 border-0 show active" id="temel-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="sayfa_baslik" class="form-label">Sayfa Başlığı <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-white" id="sayfa_baslik" name="sayfa_baslik" value="<?=$cek['sayfa_baslik']?>" required>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <label for="sayfa_tip" class="form-label">İçerik Tipi</label>
                                            <select class="form-select bg-white" name="sayfa_tip" id="sayfa_tip">
                                                <option value="1" <?=($cek['sayfa_tip'] == 1 ? 'selected' : '')?>>Kurumsal Sayfa</option>
                                                <option value="2" <?=($cek['sayfa_tip'] == 2 ? 'selected' : '')?>>Hizmet</option>
                                                <option value="3" <?=($cek['sayfa_tip'] == 3 ? 'selected' : '')?>>Çözüm</option>
                                                <option value="4" <?=($cek['sayfa_tip'] == 4 ? 'selected' : '')?>>Sözleşme</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <label for="sayfa_kisa" class="form-label">Kısa Özet / Açıklama</label>
                                            <textarea class="form-control bg-white" id="sayfa_kisa" name="sayfa_kisa" rows="3"><?=$cek['sayfa_kisa']?></textarea>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <label for="sayfa_icerik" class="form-label">Detaylı İçerik</label>
                                            <textarea class="form-control bg-white ckeditor-init" id="sayfa_icerik" name="sayfa_icerik"><?=$cek['sayfa_icerik']?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 2: Özellikler / Soru-Cevap -->
                                <div class="tab-pane fade p-0 border-0" id="ozellik-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-12">
                                            <div class="card border bg-light p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <label class="form-label fw-bold mb-0 text-primary"><i class="bi bi-list-check"></i> Dinamik Özellikler / Soru-Cevap Listesi</label>
                                                    <button type="button" class="btn btn-success btn-sm" id="yeniOzellikEkle"><i class="bi bi-plus-lg"></i> Yeni Ekle</button>
                                                </div>
                                                <div id="ozelliklerKapsayici" class="d-flex flex-column gap-2">
                                                    <?php if(!empty($mevcutOzellikler)): ?>
                                                        <?php foreach($mevcutOzellikler as$item): ?>
                                                            <div class="row g-2 align-items-center border p-2 rounded bg-white shadow-sm">
                                                                <div class="col-xl-4">
                                                                    <input type="text" class="form-control form-control-sm" name="ozellik_baslik[]" placeholder="Başlık / Soru" value="<?=htmlspecialchars($item['baslik'] ?? '')?>">
                                                                </div>
                                                                <div class="col-xl-7">
                                                                    <input type="text" class="form-control form-control-sm" name="ozellik_aciklama[]" placeholder="Açıklama / Cevap" value="<?=htmlspecialchars($item['aciklama'] ?? '')?>">
                                                                </div>
                                                                <div class="col-xl-1 text-end">
                                                                    <button type="button" class="btn btn-danger btn-sm w-100 satirSilBtn"><i class="bi bi-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 3: Görseller & Galeri -->
                                <div class="tab-pane fade p-0 border-0" id="medya-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="p-3 border rounded bg-white">
                                                <label for="sayfa_resim" class="form-label fw-bold"><i class="bi bi-image"></i> Ana Kapak Resmi</label>
                                                <input class="form-control form-control-sm py-0 ps-2" type="file" id="sayfa_resim" name="sayfa_resim" accept="image/*">
                                                
                                                <?php if (!empty($cek['sayfa_resim'])): ?>
                                                    <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                                        <img src="assets/images/sayfalar/<?= htmlspecialchars($cek['sayfa_resim']) ?>" 
                                                             alt="Kapak Görseli" class="img-thumbnail me-3 shadow-sm" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                            <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                                Mevcut Kapağı Sil
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="p-3 border rounded bg-white">
                                                <label for="galeri" class="form-label fw-bold"><i class="bi bi-images"></i> Galeriye Yeni Resimler Ekle</label>
                                                <input class="form-control form-control-sm py-0 ps-2 mb-3" type="file" id="galeri" name="galeri[]" multiple accept="image/*">
                                                
                                                <?php if ($galeri_resimleri): ?>
                                                <div class="mt-2">
                                                    <label class="form-label fw-bold mb-2 text-dark"><i class="bi bi-grid"></i> Mevcut Galeri Resimleri (Sürükleyerek Sıralayın)</label>
                                                    <div class="p-3 border rounded bg-light" style="max-height: 400px; overflow-y: auto;">
                                                        
                                                        <div id="sortable-gallery" class="row gy-3">
                                                            <?php foreach($galeri_resimleri as$gresim): ?>
                                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 text-center">
                                                                    <div class="card shadow-sm border h-100 position-relative cursor-move bg-white">
                                                                        
                                                                        <input type="hidden" name="galeri_sira[]" value="<?= $gresim['id'] ?>">

                                                                        <div class="card-header p-1 border-bottom bg-light text-muted" style="cursor: grab;">
                                                                            <i class="bi bi-arrows-move"></i> Sürükle
                                                                        </div>
                                                                        <div class="card-body p-2">
                                                                            <img src="assets/images/sayfalar/<?= htmlspecialchars($gresim['resim']) ?>" 
                                                                                 alt="Galeri" class="rounded border mb-2 w-100" style="height: 100px; object-fit: cover;">
                                                                            
                                                                            <div class="form-check text-start mb-1">
                                                                                <input class="form-check-input" type="checkbox" name="galeri_sil[]" value="<?= $gresim['id'] ?>" id="gsil_<?= $gresim['id'] ?>">
                                                                                <label class="form-check-label text-danger" style="font-size:12px;" for="gsil_<?= $gresim['id'] ?>">Sil</label>
                                                                            </div>
                                                                            
                                                                            <div class="form-check text-start">
                                                                                <input class="form-check-input" type="radio" name="kapak_yap" value="<?= $gresim['id'] ?>" id="gkapak_<?= $gresim['id'] ?>">
                                                                                <label class="form-check-label text-primary" style="font-size:12px;" for="gkapak_<?= $gresim['id'] ?>">Kapak Yap</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 4: SEO & Görünürlük -->
                                <div class="tab-pane fade p-0 border-0" id="seo-pane" role="tabpanel" tabindex="0">
                                    <div class="row gy-4">
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="sayfa_title" class="form-label">SEO Başlığı</label>
                                            <input type="text" class="form-control bg-white" id="sayfa_title" name="sayfa_title" value="<?=$cek['sayfa_title']?>">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="sayfa_description" class="form-label">SEO Açıklaması</label>
                                            <input type="text" class="form-control bg-white" id="sayfa_description" name="sayfa_description" value="<?=$cek['sayfa_description']?>">
                                        </div>

                                        <div class="col-xl-12 mt-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input fs-5" type="checkbox" name="sayfa_durum" <?=($cek['sayfa_durum'] == 1 ? 'checked' : '')?> value="1" id="sayfa_durum" role="switch">
                                                <label class="form-check-label fs-14 mt-1 ms-2" for="sayfa_durum">Sayfa Yayında (Aktif)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 fs-15 shadow-sm">
                                        <i class="bi bi-save me-2"></i> Sayfayı Güncelle
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>