<?php
$avatar_yol = !empty($giris_cek['uye_resim']) ? URL . 'assets/images/user/' . $giris_cek['uye_resim'] : URL . 'assets/images/system/user.jpg';
?>

<div class="main-content app-content">
    <div class="page-header-breadcrumb my-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h1 class="page-title fw-semibold fs-20 mb-0">Hesabım</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Ayarlar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid page-container main-body-container">
        <div class="row mb-5">
            
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-body text-center p-4">
                        <span class="avatar avatar-xxl avatar-rounded position-relative d-inline-block">
                            <img src="<?=$avatar_yol?>" alt="Profil" id="profile-img" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                            <span class="badge rounded-pill bg-primary avatar-badge position-absolute bottom-0 end-0 p-2" style="cursor: pointer;">
                                <input type="file" name="photo" class="position-absolute w-100 h-100 op-0 top-0 start-0" id="profile-change" style="cursor: pointer; opacity: 0;">
                                <i class="fe fe-camera text-white"></i>
                            </span>
                        </span>
                        <div class="fw-semibold fs-16 mt-3 mb-1" id="sidebar-name"><?=$giris_cek['uye_ad_soyad']?></div>
                        <span class="d-block fs-13 text-muted" id="sidebar-email"><?=$giris_cek['uye_eposta']?></span>
                    </div>
                </div>

                <div class="card custom-card">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                            <li class="nav-item m-1">
                                <a class="nav-link active d-flex align-items-center gap-2" data-bs-toggle="tab" role="tab" href="#personal-info" aria-selected="true">
                                    <i class="ri-user-settings-line fs-16"></i> Kişisel Bilgiler
                                </a>
                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="tab" role="tab" href="#account-settings" aria-selected="false">
                                    <i class="ri-lock-password-line fs-16"></i> Güvenlik & Şifre
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="tab-content">
                            
                            <div class="tab-pane show active p-0 border-0" id="personal-info" role="tabpanel">
                                <form action="request/user-profile" method="POST" class="postForm">
                                    <input type="hidden" name="postType" value="profileEdit">
                                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">
                                    
                                    <div class="fw-medium fs-16 mb-3 text-primary">Profil Bilgileri :</div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-12">
                                            <label class="form-label">Ad Soyad</label>
                                            <input type="text" class="form-control" name="uye_ad_soyad" value="<?=$giris_cek['uye_ad_soyad'] ?>" required>
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Kullanıcı Adı</label>
                                            <input type="text" class="form-control" name="uye_kullanici_adi" value="<?=$giris_cek['uye_kullanici_adi']?? ''?>">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Telefon / GSM</label>
                                            <input type="text" class="form-control" name="uye_telefon" value="<?=$giris_cek['uye_telefon'] ?? ''?>">
                                        </div>
                                        <div class="col-xl-12">
                                            <label class="form-label">E-Posta Adresi</label>
                                            <input type="email" class="form-control" name="uye_eposta" value="<?=$giris_cek['uye_eposta']?>" required>
                                        </div>  
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Değişiklikleri Kaydet</button>
                                </form>
                            </div>

                            <div class="tab-pane p-0 border-0" id="account-settings" role="tabpanel">
                                <form action="request/user-profile" method="POST" class="postForm">
                                    <input type="hidden" name="postType" value="Password">
                                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?? ''?>">

                                    <div class="fw-medium fs-16 mb-3 text-primary">Şifre Değiştir :</div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-12">
                                            <label class="form-label">Mevcut Şifre</label>
                                            <input type="password" class="form-control" name="old_password" required placeholder="••••••••">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Yeni Şifre</label>
                                            <input type="password" class="form-control" name="new_password" required placeholder="••••••••">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label">Yeni Şifre (Tekrar)</label>
                                            <input type="password" class="form-control" name="new_password_confirm" required placeholder="••••••••">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger"><i class="ri-key-line me-1"></i> Şifreyi Güncelle</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('profile-change').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('postType', 'update_avatar');
    formData.append('photo', file);

    const csrfToken = document.querySelector('input[name="csrf_token"]');
    if (csrfToken) {
        formData.append('csrf_token', csrfToken.value);
    }

    fetch('request/user-profile', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.type === 'success') {
            document.getElementById('profile-img').src = data.new_url;
            if (typeof showToast === 'function') {
                showToast(data.message, 'success');
            } else {
                Swal.fire('Başarılı', data.message, 'success');
            }
        } else {
            Swal.fire('Hata', data.message, 'error');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Hata', 'Fotoğraf yüklenirken bir iletişim hatası oluştu.', 'error');
    });
});
</script>