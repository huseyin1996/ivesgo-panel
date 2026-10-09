<?php

if (!modulAktifMi($db, 'kampanya_kupon') && !yetkisiVarMi("kampanyalar", 'duzenle')) {
    header("Location:" . URL . "index");
}

$sor = $db->prepare("SELECT * FROM i_kampanyalar WHERE id = :id");
$sor->execute(["id" => $par[1]]);
if($sor->rowCount() > 0){
    $kampanya = $sor->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:../kampanyalar/");
    exit;
}
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Kampanya Düzenle</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="kampanyalar/">Kampanyalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kampanya Düzenle</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Kampanya Düzele
                        </div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/campaigns" method="post">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="value" value="<?=$kampanya['id']?>">
                            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                            <div class="row gy-3">
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kampanya Adı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kampanya_adi" value="<?=htmlspecialchars($kampanya['kampanya_adi'])?>" required>
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Kupon Kodu (Opsiyonel)</label>
                                    <input type="text" class="form-control text-uppercase" name="kampanya_kodu" value="<?=htmlspecialchars($kampanya['kampanya_kodu'] ?? '')?>">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Kampanya Türü <span class="text-danger">*</span></label>
                                    <select class="form-select" name="kampanya_turu" id="kampanyaTuru">
                                        <option value="yuzde_indirim" <?=($kampanya['kampanya_turu']=='yuzde_indirim'?'selected':'')?>>Sepette Yüzde İndirim (%)</option>
                                        <option value="tutar_indirim" <?=($kampanya['kampanya_turu']=='tutar_indirim'?'selected':'')?>>Tutar İndirimi (₺)</option>
                                        <option value="ucretsiz_kargo" <?=($kampanya['kampanya_turu']=='ucretsiz_kargo'?'selected':'')?>>Ücretsiz Kargo</option>
                                    </select>
                                </div>

                                <div class="col-xl-4" id="indirimDegerAlani" style="display: <?=($kampanya['kampanya_turu']=='ucretsiz_kargo'?'none':'block')?>;">
                                    <label class="form-label fw-bold">İndirim Oranı / Tutarı</label>
                                    <input type="number" step="0.01" class="form-control" name="indirim_orani" value="<?=$kampanya['indirim_orani']?>">
                                </div>

                                <div class="col-xl-4">
                                    <label class="form-label fw-bold">Minimum Sepet Tutarı (₺)</label>
                                    <input type="number" step="0.01" class="form-control" name="min_sepet_tutar" value="<?=$kampanya['min_sepet_tutar']?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Başlangıç Tarihi</label>
                                    <input type="datetime-local" class="form-control" name="baslangic_tarihi" value="<?=!empty($kampanya['baslangic_tarihi'])?date('Y-m-d\TH:i', strtotime($kampanya['baslangic_tarihi'])):''?>">
                                </div>

                                <div class="col-xl-6">
                                    <label class="form-label fw-bold">Bitiş Tarihi</label>
                                    <input type="datetime-local" class="form-control" name="bitis_tarihi" value="<?=!empty($kampanya['bitis_tarihi'])?date('Y-m-d\TH:i', strtotime($kampanya['bitis_tarihi'])):''?>">
                                </div>

                                <div class="col-xl-12 mt-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-5" type="checkbox" name="durum" value="1" id="durumSwitch" <?=($kampanya['durum']==1?'checked':'')?>>
                                        <label class="form-check-label fw-bold ms-2 mt-1" for="durumSwitch">Kampanya Aktif Olsun mu?</label>
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                        <i class="bi bi-check2-circle me-1"></i> Değişiklikleri Kaydet
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