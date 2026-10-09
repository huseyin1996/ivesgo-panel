<?php $kilavuzVerisi = !empty($ayar['kullanim_kilavuzu']) ? json_decode($ayar['kullanim_kilavuzu'], true) : []; ?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Kullanım Kılavuzu & SSS</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kullanım Kılavuzu</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <!-- Üst Arama Banner Alanı -->
        <div class="row justify-content-center mb-5">
            <div class="col-xl-7 text-center">
                <div class="card custom-card bg-primary-transparent border-0 shadow-none">
                    <div class="card-body p-5">
                        <span class="badge bg-primary-transparent text-primary mb-2">Destek ve Rehber Merkezi</span>
                        <h3 class="fw-bold mb-3 text-dark">Neyi, Nasıl Yapabilirsiniz?</h3>
                        <p class="text-muted fs-15 mb-4">CRM üzerinde takıldığınız tüm konuları ve işlem adımlarını aşağıda bulabilirsiniz.</p>
                        <div class="input-group">
                            <input type="text" id="faqArama" class="form-control form-control-lg" placeholder="Sorunuzu veya anahtar kelimeyi yazın..." aria-label="Arama">
                            <button class="btn btn-primary px-4" type="button"><i class="ri-search-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="faqContainer">
            <div class="col-xl-10">
                <?php if (!empty($kilavuzVerisi)): foreach ($kilavuzVerisi as $mIndex => $modul): ?>
                    
                    <div class="mb-4 faq-item" data-category="<?=htmlspecialchars($modul['baslik'] ?? '')?>">
                        <h5 class="fw-bold mb-3 text-primary">
                            <i class="ri-folder-line me-2"></i><?=htmlspecialchars($modul['baslik'] ?? '')?>
                        </h5>
                        
                        <div class="accordion custom-accordion" id="accordionModul<?=$mIndex?>">
                            <?php if (!empty($modul['sorular'])): foreach ($modul['sorular'] as $sIndex => $soru): 
                                $collapseId = "collapse_" . $mIndex . "_" . $sIndex;
                                $headingId = "heading_" . $mIndex . "_" . $sIndex;
                            ?>
                                <div class="accordion-item mb-2 border rounded shadow-sm">
                                    <h2 class="accordion-header" id="<?=$headingId?>">
                                        <button class="accordion-button <?=($sIndex > 0 ? 'collapsed' : '')?> fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#<?=$collapseId?>" aria-expanded="<?=($sIndex == 0 ? 'true' : 'false')?>" aria-controls="<?=$collapseId?>">
                                            <?=htmlspecialchars($soru['soru'] ?? '')?>
                                        </button>
                                    </h2>
                                    <div id="<?=$collapseId?>" class="accordion-collapse collapse <?=($sIndex == 0 ? 'show' : '')?>" aria-labelledby="<?=$headingId?>" data-bs-parent="#accordionModul<?=$mIndex?>">
                                        <div class="accordion-body text-muted" style="white-space: pre-line;">
                                            <?=htmlspecialchars($soru['cevap'] ?? '')?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>