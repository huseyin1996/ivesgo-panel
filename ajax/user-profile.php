<?php
$data = [];

if(isset($_POST)){
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
            exit;
        }
    }
    
    $uye_id = $_SESSION['uye_id'];

    if (!isset($uye_id)) {
        echo json_encode(['type' => 'error', 'message' => 'Oturum açmanız gerekiyor.']);
        exit;
    }


    if ($postType == "profileEdit") {

        if (empty($uye_ad_soyad) || empty($uye_eposta)  || empty($uye_telefon)) {
            alert("Hata","Ad soyad, telefon no ve e-posta alanları boş bırakılamaz.","error");
            exit;
        }

        $kontrol = $db->prepare("SELECT uye_id FROM i_uyeler WHERE uye_eposta = ? AND uye_id != ?");
        $kontrol->execute([$uye_eposta, $uye_id]);
        if ($kontrol->rowCount() > 0) {
            alert("Hata","Bu e-posta adresi başka bir kullanıcı tarafından kullanılmaktadır.","error");
            exit;
        }

        if (!empty($uye_kullanici_adi)) {
            $kontrol = $db->prepare("SELECT uye_id FROM i_uyeler WHERE uye_kullanici_adi = ? AND uye_id != ?");
            $kontrol->execute([$uye_kullanici_adi, $uye_id]);
            if ($kontrol->rowCount() > 0) {
                alert("Hata","Bu kullanıcı adı başka bir kullanıcı tarafından kullanılmaktadır.","error");
                exit;
            }
        }


        $array = [
            "uye_ad_soyad"      => $uye_ad_soyad,
            "uye_eposta"        => $uye_eposta,
            "uye_kullanici_adi" => !empty($uye_kullanici_adi) ? $uye_kullanici_adi : '',
            "uye_telefon"       => $uye_telefon,
            "uye_id"            => $uye_id
        ];
        $update = $db->prepare("UPDATE i_uyeler SET
            uye_ad_soyad        = :uye_ad_soyad,
            uye_eposta          = :uye_eposta,
            uye_kullanici_adi   = :uye_kullanici_adi,
            uye_telefon         = :uye_telefon
            WHERE uye_id        = :uye_id");
        $kontrol = $update->execute($array);

        if($kontrol){
            alert("Başarılı","Hesap bilgileri başarıyla güncellenmiştir.","success",true);
        }else{
            alert("Hata","Bir sorun oluştu.","error");
        }
    }


    if ($postType == "Password") {

        if (empty($old_password) || empty($new_password) || empty($new_password_confirm)) {
            alert("Hata","Lütfen tüm şifre alanlarını doldurun.","error");
            exit;
        }

        if ($new_password !== $new_password_confirm) {
            alert("Hata","Yeni şifreler birbiriyle uyuşmuyor.","error");
            exit;
        }

        $sorgu = $db->prepare("SELECT uye_sifre FROM i_uyeler WHERE uye_id = ?");
        $sorgu->execute([$uye_id]);
        $uye = $sorgu->fetch(PDO::FETCH_ASSOC);


        if ($giris_cek && password_verify($old_password, $uye['uye_sifre'])) {
            $sifre = password_hash($new_password, PASSWORD_DEFAULT);

            $upd = $db->prepare("UPDATE i_uyeler SET uye_sifre = ?, eski_sifreler = ?  WHERE uye_id = ?");
            $upd->execute([$sifre, $uye['uye_sifre'], $uye_id]);

            alert("Başarılı","Şifreniz başarıyla değiştirildi.","success",true);
        } else {
            alert("Hata","Mevcut şifrenizi hatalı girdiniz.","error");
        }
    }


    if ($postType == "update_avatar") {
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            
            $sorgu = $db->prepare("SELECT uye_resim FROM i_uyeler WHERE uye_id = ?");
            $sorgu->execute([$uye_id]);
            $uye = $sorgu->fetch(PDO::FETCH_ASSOC);

            $avatar_dir = 'assets/images/user/';
            if (!is_dir($avatar_dir)) { mkdir($avatar_dir, 0755, true); }

            $yukle = resim_yukle($_FILES['photo'], $avatar_dir, 'avatar_');
            if ($yukle) {
                if (!empty($uye['uye_resim']) && file_exists($avatar_dir . $uye['uye_resim'])) {
                    @unlink($avatar_dir . $uye['uye_resim']);
                }

                $upd = $db->prepare("UPDATE i_uyeler SET uye_resim = ? WHERE uye_id = ?");
                $upd->execute([$yukle, $uye_id]);

                echo json_encode([
                    'type' => 'success', 
                    'message' => 'Profil fotoğrafı güncellendi.', 
                    'new_url' => URL . $avatar_dir . $yukle
                ]);
                exit;
            }
        }
        echo json_encode(['type' => 'error', 'message' => 'Fotoğraf yüklenemedi.']);
        exit;
    }

}
