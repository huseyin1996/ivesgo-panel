<?php
yetkisiVarMi('ayarlar', 'duzenle');

$kilavuzVerisi = !empty($ayar['kullanim_kilavuzu']) ? json_decode($ayar['kullanim_kilavuzu'], true) : [];
?>

<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Kullanım Kılavuzu Yönetimi</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index">Anasayfa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kılavuz Yönetimi</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <form class="postForm" action="request/settings" method="post">
            <input type="hidden" name="postType" value="EditKilavuz">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title fw-bold">Modül ve SSS İçerik Düzenleyicisi</div>
                            <button type="button" class="btn btn-success btn-sm" id="modulEkleBtn">
                                <i class="ri-add-line me-1"></i> Yeni Modül Başlığı Ekle
                            </button>
                        </div>
                        <div class="card-body" id="modullerWrapper">
                            
                            <?php if (!empty($kilavuzVerisi)): foreach ($kilavuzVerisi as $mIndex =>$modul): ?>
                                <div class="card border mb-4 modul-item shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <input type="text" class="form-control fw-bold" name="moduller[<?=$mIndex?>][baslik]" value="<?=htmlspecialchars($modul['baslik'] ?? '')?>" placeholder="Modül Başlığı (Örn: 1. Müşteri Yönetimi)" required>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm modulSilBtn"><i class="ri-delete-bin-line"></i> Modülü Sil</button>
                                        </div>
                                    </div>
                                    <div class="card-body sss-wrapper">
                                        <label class="form-label text-muted fs-13 fw-semibold mb-2">Alt Soru ve Cevaplar:</label>
                                        
                                        <?php if (!empty($modul['sorular'])): foreach ($modul['sorular'] as $sIndex =>$soru): ?>
                                            <div class="row g-2 align-items-center mb-3 sss-row">
                                                <div class="col-xl-5">
                                                    <input type="text" class="form-control" name="moduller[<?=$mIndex?>][sorular][<?=$sIndex?>][soru]" value="<?=htmlspecialchars($soru['soru'] ?? '')?>" placeholder="Soru / Başlık" required>
                                                </div>
                                                <div class="col-xl-6">
                                                    <textarea class="form-control" name="moduller[<?=$mIndex?>][sorular][<?=$sIndex?>][cevap]" rows="1" placeholder="Adım adım açıklama / cevap" required><?=htmlspecialchars($soru['cevap'] ?? '')?></textarea>
                                                </div>
                                                <div class="col-xl-1 text-end">
                                                    <button type="button" class="btn btn-outline-danger btn-sm w-100 satirSilBtn"><i class="ri-close-line"></i></button>
                                                </div>
                                            </div>
                                        <?php endforeach; endif; ?>

                                    </div>
                                    <div class="card-footer bg-white border-top-0 text-end">
                                        <button type="button" class="btn btn-primary btn-sm satirEkleBtn">
                                            <i class="ri-add-circle-line me-1"></i> Bu Modüle Soru Ekle (Add Row)
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; else: ?>
                                <div class="text-center text-muted py-4">Henüz kılavuz içeriği eklenmemiş. Yukarıdaki butondan modül ekleyebilirsiniz.</div>
                            <?php endif; ?>

                        </div>
                        <div class="card-footer border-top text-end">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="ri-save-line me-1"></i> Değişiklikleri Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Dinamik Ekleme / Klonlama (Clone / Add Row) için JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let wrapper = document.getElementById('modullerWrapper');

    // 1. Yeni Modül Ekle
    document.getElementById('modulEkleBtn').addEventListener('click', function() {
        let mIndex = document.querySelectorAll('.modul-item').length;
        let html = `
            <div class="card border mb-4 modul-item shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 me-3">
                        <input type="text" class="form-control fw-bold" name="moduller[${mIndex}][baslik]" placeholder="Modül Başlığı (Örn: Yeni Modül)" required>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger btn-sm modulSilBtn"><i class="ri-delete-bin-line"></i> Modülü Sil</button>
                    </div>
                </div>
                <div class="card-body sss-wrapper">
                    <label class="form-label text-muted fs-13 fw-semibold mb-2">Alt Soru ve Cevaplar:</label>
                    <div class="row g-2 align-items-center mb-3 sss-row">
                        <div class="col-xl-5">
                            <input type="text" class="form-control" name="moduller[${mIndex}][sorular][0][soru]" placeholder="Soru / Başlık" required>
                        </div>
                        <div class="col-xl-6">
                            <textarea class="form-control" name="moduller[${mIndex}][sorular][0][cevap]" rows="1" placeholder="Adım adım açıklama / cevap" required></textarea>
                        </div>
                        <div class="col-xl-1 text-end">
                            <button type="button" class="btn btn-outline-danger btn-sm w-100 satirSilBtn"><i class="ri-close-line"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 text-end">
                    <button type="button" class="btn btn-primary btn-sm satirEkleBtn">
                        <i class="ri-add-circle-line me-1"></i> Bu Modüle Soru Ekle (Add Row)
                    </button>
                </div>
            </div>
        `;
        // Eğer ilk "Henüz içerik eklenmemiş" yazısı varsa kaldıralım
        let emptyMsg = wrapper.querySelector('.text-center.text-muted');
        if(emptyMsg) emptyMsg.remove();

        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // 2. Modül İçine Alt Soru Satırı Ekle (Clone / Add Row)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.satirEkleBtn')) {
            let btn = e.target.closest('.satirEkleBtn');
            let modulCard = btn.closest('.modul-item');
            let sssWrapper = modulCard.querySelector('.sss-wrapper');
            let mIndex = Array.from(document.querySelectorAll('.modul-item')).indexOf(modulCard);
            let sIndex = sssWrapper.querySelectorAll('.sss-row').length;

            let rowHtml = `
                <div class="row g-2 align-items-center mb-3 sss-row">
                    <div class="col-xl-5">
                        <input type="text" class="form-control" name="moduller[${mIndex}][sorular][${sIndex}][soru]" placeholder="Soru / Başlık" required>
                    </div>
                    <div class="col-xl-6">
                        <textarea class="form-control" name="moduller[${mIndex}][sorular][${sIndex}][cevap]" rows="1" placeholder="Adım adım açıklama / cevap" required></textarea>
                    </div>
                    <div class="col-xl-1 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 satirSilBtn"><i class="ri-close-line"></i></button>
                    </div>
                </div>
            `;
            sssWrapper.insertAdjacentHTML('beforeend', rowHtml);
        }

        // 3. Modül Silme
        if (e.target.closest('.modul-item .modulSilBtn')) {
            e.target.closest('.modul-item').remove();
        }

        // 4. Alt Soru Satırı Silme
        if (e.target.closest('.satirSilBtn')) {
            let row = e.target.closest('.sss-row');
            let sssWrapper = row.closest('.sss-wrapper');
            if (sssWrapper.querySelectorAll('.sss-row').length > 1) {
                row.remove();
            } else {
                alert('Her modülde en az 1 soru satırı bulunmalıdır.');
            }
        }
    });
});
</script>