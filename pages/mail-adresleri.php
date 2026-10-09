<?php 
$modulAdi = 'mail'; 

if (!modulAktifMi($db, 'mail') && !yetkisiVarMi($modulAdi, 'goruntule')) {
    header("Location:" . URL . "index");
    exit;
}

$butonlarDizi = [];
if (yetkisiVarMi($modulAdi, 'duzenle')) {
    $butonlarDizi[] = 'duzenle';
}
if (yetkisiVarMi($modulAdi, 'sil')) {
    $butonlarDizi[] = 'sil';
}

$butonlar = !empty($butonlarDizi) ? implode(',', $butonlarDizi) : 'yok';

print_r($butonlar);
?>
<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-medium fs-20 mb-0">cPanel Mail Hesapları Yönetimi</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Yönetim</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mail Hesapları</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0">
                    <div class="card-header justify-content-between bg-white border-bottom">
                        <div class="card-title fw-bold">Kayıtlı E-Posta Hesapları</div>
                        <?php if (yetkisiVarMi($modulAdi, 'ekle')): ?>
                            <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#yeniMailModal">
                                <i class="bi bi-plus-lg me-1"></i> Yeni Mail Hesabı Ekle
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap w-100 dynamic-datatable" data-page="ivesgo" data-type="mail">
                                <thead class="table-light">
                                    <tr>
                                        <th data-name="email">E-Posta Adresi</th>
                                        <th data-name="humandiskused">Kullanılan Alan</th>
                                        <th data-name="humandiskquota">Toplam Kota</th>
                                        <th data-name="email" data-type="islem" data-buttons="<?=$butonlar?>">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$siteDomain = $_SERVER['SERVER_NAME'];
$siteDomain = preg_replace('#^https?://#','',$siteDomain);
$siteDomain = preg_replace('#^www\.#','',$siteDomain);
$siteDomain = explode('/',$siteDomain)[0];
?>

<!-- Yeni Mail Ekleme Modalı -->
<div class="modal fade" id="yeniMailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Yeni Mail Hesabı Oluştur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form class="postForm" action="request/ivesgo" method="post" enctype="multipart/form-data">
                <input type="hidden" name="postType" value="add_mail_account">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-Posta Adresi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="email_prefix" placeholder="ornek" required>
                            <span class="input-group-text">@<?=$siteDomain?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Şifre</label>
                        <input type="password" class="form-control" name="password" placeholder="Güçlü bir şifre giriniz" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kota (MB)</label>
                        <!-- disabled kaldırıldı, form gönderiminde sorun yaratmaması için readonly yapıldı -->
                        <input type="number" class="form-control" name="quota" value="250" placeholder="250" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Hesabı Oluştur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Şifre Değiştirme Modalı -->
<div class="modal fade" id="sifreDegistirModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Mail Şifresi Değiştir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form class="postForm" action="request/ivesgo" method="post" enctype="multipart/form-data">
                <input type="hidden" name="postType" value="update_mail_password">
                <!-- Tablodan seçilen mail adresi buraya otomatik aktarılacak -->
                <input type="hidden" name="email" id="sifreDegisEmail">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-Posta Adresi</label>
                        <input type="text" class="form-control" id="sifreDegisEmailGoster" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Yeni Şifre</label>
                        <input type="password" class="form-control" name="password" placeholder="Yeni şifreyi giriniz" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Şifreyi Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function sifre_degistir(email) {
    document.getElementById('sifreDegisEmail').value = email;
    document.getElementById('sifreDegisEmailGoster').value = email;
    var myModal = new bootstrap.Modal(document.getElementById('sifreDegistirModal'));
    myModal.show();
}
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        let btn = e.target.closest(".btn-edit, [data-action='duzenle']");
        if (btn) {
            e.preventDefault();
            e.stopPropagation();
            
            let email = btn.getAttribute('data-id') || btn.dataset.email;
            
            if (!email) {
                let row = btn.closest("tr");
                if (row) {
                    let emailCell = row.querySelector("td");
                    if (emailCell) email = emailCell.innerText.trim();
                }
            }

            if (email) {
                sifre_degistir(email);
            } else {
                alert("Mail adresi alınamadı.");
            }
        }
    });
});
</script>