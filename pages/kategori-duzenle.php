<?php
    if (!modulAktifMi($db, 'kategoriler') && !yetkisiVarMi("kategoriler", 'duzenle')) {
        header("Location:" . URL . "index");
    }
    $sor = $db->prepare("SELECT * FROM i_kategoriler WHERE id=:id");
    $sor->execute(array("id" => $par[1]));
    if($sor->rowCount() > 0){
        $cek = $sor->fetch(PDO::FETCH_ASSOC);
    }else{
        header("Location:".URL."kategoriler/");
    }


$kategori_sorgu = $db->query("SELECT id, ust_id, kategori_adi FROM i_kategoriler ORDER BY sira ASC, kategori_adi ASC")->fetchAll(PDO::FETCH_ASSOC);

$kategori_agaci = [];
foreach ($kategori_sorgu as $kategori) {
    $kategori_agaci[$kategori['ust_id']][] = $kategori;
}

function kategori_secenekleri_olustur($agac, $ust_id = 0, $derinlik = 0, $secili_id = null, $duzenlenen_id = null) {
    if (isset($agac[$ust_id])) {
        foreach ($agac[$ust_id] as $kat) {
            
            if ($duzenlenen_id == $kat['id']) continue; 
            $girinti = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $derinlik) . ($derinlik > 0 ? "↳ " : "");
            $secili = ($secili_id == $kat['id']) ? 'selected' : '';
            echo '<option value="' . $kat['id'] . '" ' . $secili . '>' . $girinti . htmlspecialchars($kat['kategori_adi']) . '</option>';
            kategori_secenekleri_olustur($agac, $kat['id'], $derinlik + 1, $secili_id, $duzenlenen_id);
        }
    }
}
?>
<div class="main-content app-content">       
    <div class="page-header-breadcrumb my2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">Kategoriler</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Kategoriler</a></li>
                <li class="breadcrumb-item"><a href="musteriler/">Tüm Kategoriler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori Düzele</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Kategori Düzele
                        </div>
                        <div class="prism-toggle">
                            (Son Güncelleme : <?=(!empty($cek['guncelleme_tarihi']) ? tarihSaat($cek['guncelleme_tarihi']) : tarihSaat($cek['eklenme_tarihi']))?>)
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="postForm" action="request/categorys" method="post" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="value" value="<?=$cek['id']?>">
                            <input type="hidden" name="postType" value="Edit">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                            <div class="row gy-4">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="ust_id" class="form-label">Üst Kategori</label>
                                    <select class="form-control" name="ust_id" data-trigger id="ust_id">
                                        <option value="0">Üst Kategori Seçiniz</option>
                                        <option value="0">Ana Kategori</option>
                                        <?php 
                                        $mevcut_ust_id = $cek['ust_id'] ?? null; 
                                        $mevcut_kendi_id = $cek['id'] ?? null;
                                        kategori_secenekleri_olustur($kategori_agaci, 0, 0, $mevcut_ust_id, $mevcut_kendi_id); 
                                        ?>
                                    </select>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="kategori_adi" class="form-label">Kategori Adı</label>
                                    <input type="text" class="form-control" id="kategori_adi" name="kategori_adi" value="<?=$cek['kategori_adi']?>" placeholder="Kategori Adı Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="kategori_icon" class="form-label">Kategori İcon</label>
                                    <input type="text" class="form-control" id="kategori_icon" name="kategori_icon" value="<?=$cek['kategori_icon']?>" placeholder="Kategori İcon Giriniz (FontAwesome vb.).">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_title" class="form-label">Kategori Title</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="<?=$cek['seo_title']?>" placeholder="Kategori Title Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="seo_description" class="form-label">Kategori Description</label>
                                    <input type="text" class="form-control" id="seo_description" name="seo_description" value="<?=$cek['seo_description']?>" placeholder="Kategori Description Giriniz.">
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <label for="kategori_resim" class="form-label">Kategori Resim</label>
                                    <input class="form-control py-1" type="file" id="kategori_resim" name="kategori_resim" accept="image/*">
                                    
                                    <?php if (!empty($cek['kategori_resim'])): ?>
                                        <div class="mt-3 p-2 border rounded bg-light d-flex align-items-center">
                                            <img src="assets/images/kategoriler/thumb/<?=$cek['kategori_resim']?>" alt="Kategori Görseli" class="img-thumbnail me-3 shadow-sm" width="100">
                                                 
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="resmi_sil" value="1" id="resmi_sil" role="switch">
                                                <label class="form-check-label text-danger fw-bold cursor-pointer" for="resmi_sil">
                                                    <i class="bi bi-trash"></i> Mevcut Resmi Sil
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label for="kategori_aciklama" class="form-label">Kategori Açıklama</label>
                                    <textarea class="form-control ckeditor-init" id="kategori_aciklama" name="kategori_aciklama"><?=$cek['kategori_aciklama']?></textarea>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Bilgileri Kaydet</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>