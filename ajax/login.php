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
    
    if (isset($_SESSION["login_lock_time"]) && time() < $_SESSION["login_lock_time"]) {
        $kalan_dakika = ceil(($_SESSION["login_lock_time"] - time()) / 60);
        alert("Hata", "Çok fazla başarısız giriş denemesi yaptınız. Lütfen {$kalan_dakika} dakika bekleyin.", "error");
        exit;
    } elseif (isset($_SESSION["login_lock_time"]) && time() >= $_SESSION["login_lock_time"]) {
        unset($_SESSION["login_lock_time"]);
        $_SESSION["login_attempts"] = 0;
    }


    if(isset($_POST['sms_dogrulama_kodu']) && isset($_SESSION['temp_login_uye_id'])) {
        $girilen_kod = trim($_POST['sms_dogrulama_kodu']);
        $gercek_kod  = $_SESSION['temp_sms_kodu'] ?? '';

        if(!empty($gercek_kod) && $girilen_kod === $gercek_kod) {
            $uye_id = $_SESSION['temp_login_uye_id'];
            
            $giris = $db->prepare("SELECT * FROM i_uyeler WHERE uye_id = ?");
            $giris->execute([$uye_id]);
            $bilgi_cek = $giris->fetch(PDO::FETCH_ASSOC);

            if($bilgi_cek) {
                unset($_SESSION['temp_login_uye_id']);
                unset($_SESSION['temp_sms_kodu']);

                $_SESSION["login_attempts"] = 0;
                unset($_SESSION["login_lock_time"]);

                $giris_token = md5(uniqid(mt_rand(), true));
                $ip_adresi   = $_SERVER['REMOTE_ADDR'] ?? '';
                $cihaz_bilgi = $_SERVER['HTTP_USER_AGENT'] ?? '';

                $_SESSION["uye_id"]        = $bilgi_cek['uye_id'];
                $_SESSION["uye_ad_soyad"]  = $bilgi_cek['ad_soyad'] ?? $bilgi_cek['uye_ad_soyad'];
                $_SESSION["uye_eposta"]    = $bilgi_cek['uye_eposta'];
                $_SESSION["uye_onay"]      = 1;
                $_SESSION["uye_rutbe"]     = $bilgi_cek['uye_rutbe'];
                $_SESSION["giris_token"]   = $giris_token;

                // Giriş Bildirimi Ekle
                if (function_exists('bildirimEkle')) {
                    $adSoyad = $bilgi_cek['ad_soyad'] ?? ($bilgi_cek['uye_ad_soyad'] ?? 'Kullanıcı');
                    
                    bildirimEkle(
                        $db, 
                        "Sisteme Giriş Yapıldı", 
                        "{$adSoyad} adlı kullanıcı sisteme başarıyla giriş yaptı.", 
                        $bilgi_cek['uye_id'], 
                        "success", 
                        "index"
                    );
                }

                echo json_encode(['type' => 'success', 'redirect' => URL.'index']);
                exit;
            }
        } else {
            echo json_encode([
                'type' => 'error', 
                'message' => 'Girdiğiniz SMS doğrulama kodu hatalı. Lütfen tekrar deneyin.',
                'code_error' => true
            ]);
            exit;
        }
    }

    if(!empty($email) && !empty($password)){
        if(!isset($_SESSION["login_attempts"])) {
            $_SESSION["login_attempts"] = 0;
        }

        $giris = $db->prepare("SELECT * FROM i_uyeler WHERE (uye_eposta = :uye_eposta OR uye_kullanici_adi = :user_kod)");
        $giris->execute([
            "uye_eposta" => $email,
            "user_kod"   => $email
        ]);

        if($giris->rowCount() > 0){
            $bilgi_cek = $giris->fetch(PDO::FETCH_ASSOC);

            if ($bilgi_cek && password_verify($password, $bilgi_cek["uye_sifre"])) {

                if($bilgi_cek["uye_onay"] == 1){
                    
                    $dogrulama = function_exists('modulAktifMi') && modulAktifMi($db, 'giris_dogrulama');

                    if ($dogrulama) {
                        $telefon = $bilgi_cek['uye_telefon'];
                        
                        if (!empty($telefon)) {
                            $sms_kodu = rand(100000, 999999);
                            
                            $_SESSION['temp_login_uye_id'] = $bilgi_cek['uye_id'];
                            $_SESSION['temp_sms_kodu'] = strval($sms_kodu);

                            if (function_exists('smsGonder')) {
                                $smsModul = function_exists('modulAktifMi') && modulAktifMi($db, 'sms_bildirimleri');
                                if ($smsModul) {
                                    $sms_metni = "Giris Dogrulama Kodunuz: " . $sms_kodu;
                                    smsGonder($db, $telefon, $sms_metni);
                                }

                                $sms_metni = "Giriş yapabilmeniz için gerekli doğrulama kodunuz : " . $sms_kodu;
                                MailGonder($db, "Giriş Doğrulama Kodunuz", $sms_metni, $email);
                            }

                            echo json_encode([
                                'type' => 'require_2fa',
                                'message' => 'Telefonunuza bir doğrulama kodu gönderildi.'
                            ]);
                            exit;
                        }
                    }

                    $_SESSION["login_attempts"] = 0;
                    unset($_SESSION["login_lock_time"]);

                    $giris_token = md5(uniqid(mt_rand(), true));
                    $ip_adresi   = $_SERVER['REMOTE_ADDR'] ?? '';
                    $cihaz_bilgi = $_SERVER['HTTP_USER_AGENT'] ?? '';

                    $_SESSION["uye_id"]        = $bilgi_cek['uye_id'];
                    $_SESSION["uye_ad_soyad"]  = $bilgi_cek['ad_soyad'] ?? $bilgi_cek['uye_ad_soyad'];
                    $_SESSION["uye_eposta"]    = $bilgi_cek['uye_eposta'];
                    $_SESSION["uye_onay"]      = 1;
                    $_SESSION["uye_rutbe"]     = $bilgi_cek['uye_rutbe'];
                    $_SESSION["giris_token"]   = $giris_token;

                    if(isset($remember) && $remember == 1) {
                        $remember_token = bin2hex(random_bytes(32));
                        
                        if ($bilgi_cek['son_giris_ip'] != $ip_adresi) {
                            sistemLogEkle($db, 'LOGIN', 'Giriş', "Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı {$bilgi_cek['uye_id']} - {$bilgi_cek['uye_ad_soyad']}, IP Adresi {$ip_adresi}, Cihaz Bilgisi {$cihaz_bilgi}");
                        }

                        $db->prepare("UPDATE i_uyeler SET remember_token = ?, giris_token = ?, son_giris_ip = ?, son_giris_cihaz = ? WHERE uye_id = ?")
                            ->execute([$remember_token, $giris_token, $ip_adresi, $cihaz_bilgi, $bilgi_cek['uye_id']]);

                        setcookie('user_remember_token', $remember_token, time() + (86400 * 30), "/", "", false, true);
                    } else {
                        if ($bilgi_cek['son_giris_ip'] != $ip_adresi) {
                            sistemLogEkle($db, 'LOGIN', 'Giriş', "Farklı Tarayıcıdan Giriş Yapıldı. Üye Bilgileri : Üye ID - Adı Soyadı {$bilgi_cek['uye_id']} - {$bilgi_cek['uye_ad_soyad']}, IP Adresi {$ip_adresi}, Cihaz Bilgisi {$cihaz_bilgi}");
                        }
                        $db->prepare("UPDATE i_uyeler SET giris_token = ?, son_giris_ip = ?, son_giris_cihaz = ? WHERE uye_id = ?")
                            ->execute([$giris_token, $ip_adresi, $cihaz_bilgi, $bilgi_cek['uye_id']]);
                    }
                    
                    if (function_exists('bildirimEkle')) {
                        $adSoyad = $bilgi_cek['ad_soyad'] ?? ($bilgi_cek['uye_ad_soyad'] ?? 'Kullanıcı');
                        
                        bildirimEkle(
                            $db, 
                            "Sisteme Giriş Yapıldı", 
                            "{$adSoyad} adlı kullanıcı sisteme başarıyla giriş yaptı.", 
                            $bilgi_cek['uye_id'], 
                            "success", 
                            "index"
                        );
                    }

                    alert(null, URL.'index');

                } else {
                    alert("Hata", "Hesabınız henüz onaylanmamıştır.", "error");
                }
            } else {
                $_SESSION["login_attempts"] += 1;
                if ($_SESSION["login_attempts"] > 5) {
                    $_SESSION["login_lock_time"] = time() + (10 * 60);
                    alert("Hata", "Çok fazla başarısız giriş denemesi yaptınız. Lütfen 10 dakika bekleyin.", "error");
                } else {
                    alert("Hata", "Kullanıcı Bilgilerinizi Kontrol Ediniz", "error");
                }
            }

        } else {
            $_SESSION["login_attempts"] += 1;
            if ($_SESSION["login_attempts"] > 5) {
                $_SESSION["login_lock_time"] = time() + (10 * 60);
                alert("Hata", "Çok fazla başarısız giriş denemesi yaptınız. Lütfen 10 dakika bekleyin.", "error");
            } else {
                alert("Hata", "Kullanıcı Bilgilerinizi Kontrol Ediniz", "error");
            }
        }
    } else {
        alert("Uyarı", "Lütfen Boş Bırakmayınız", "warning");
    }
} else {
    header("Location:" . URL . "404");
    exit;
}
?>