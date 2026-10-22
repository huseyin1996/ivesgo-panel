<?php
$data = [];

if (isset($_POST)) {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            alert("Hata", "Güvenlik doğrulaması (CSRF) başarısız. Lütfen sayfayı yenileyin.", "error");
            exit;
        }
    }

    $postType = $_POST['postType'] ?? '';

    if ($postType === 'PasswordForget') {

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            alert("Hata", "Lütfen e-posta adresinizi boş bırakmayın.", "error");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            alert("Hata", "Lütfen geçerli bir e-posta adresi girin.", "error");
            exit;
        }

        $stmt = $db->prepare("SELECT uye_id, uye_ad_soyad, uye_eposta FROM i_uyeler WHERE uye_eposta = ?");
        $stmt->execute([$email]);
        $uye = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($uye) {
            $sifirla_token = bin2hex(random_bytes(32));
            $kod_tarih = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $update = $db->prepare("UPDATE i_uyeler SET sifre_kod = ?, sifre_kod_tarih = ? WHERE uye_id = ?");
            $update->execute([$sifirla_token, $kod_tarih, $uye['uye_id']]);

            $sifirlamaLink = URL . "sifre-sifirla?token=" . $sifirla_token;

            if (function_exists('MailGonder')) {
                $mesaj_icerigi = "Merhaba " . ($uye['uye_ad_soyad'] ?? 'Kullanıcı') . ",<br><br>"
                               . "Şifrenizi yenilemek için aşağıdaki bağlantıya tıklayabilirsiniz. Bu bağlantı 1 saat süreyle geçerlidir:<br><br>"
                               . "<a href='" . $sifirlamaLink . "'>" . $sifirlamaLink . "</a><br><br>"
                               . "Eğer bu talebi siz yapmadıysanız, bu e-postayı dikkate almayın.";
                
                MailGonder($db, "Şifre Sıfırlama Talebi", $mesaj_icerigi, $uye['uye_eposta']);
            }

            if (function_exists('sistemLogEkle')) {
                sistemLogEkle($db, 'PASSWORD_RESET', 'Şifre Sıfırlama', "Üye ID: {$uye['uye_eposta']} için şifre sıfırlama bağlantısı oluşturuldu.");
            }
        }

        alert("Başarılı", "Eğer girdiğiniz e-posta adresi sistemimizde kayıtlı ise şifre sıfırlama talimatları gönderilmiştir.", "success");
        exit;
    }

    if ($postType === 'PasswordResetUpdate') {
        $token             = trim($_POST['token'] ?? '');
        $yeni_sifre        = $_POST['yeni_sifre'] ?? '';
        $yeni_sifre_tekrar = $_POST['yeni_sifre_tekrar'] ?? '';

        if (empty($token) || empty($yeni_sifre) || empty($yeni_sifre_tekrar)) {
            alert("Hata", "Lütfen tüm alanları eksiksiz doldurun.", "error");
            exit;
        }

        if (strlen($yeni_sifre) < 6) {
            alert("Hata", "Yeni şifreniz en az 6 karakterden olmalıdır.", "error");
            exit;
        }

        if ($yeni_sifre !== $yeni_sifre_tekrar) {
            alert("Hata", "Girdiğiniz şifreler birbiriyle uyuşmuyor.", "error");
            exit;
        }

        $stmt = $db->prepare("SELECT uye_id FROM i_uyeler WHERE sifre_kod = ? AND sifre_kod_tarih >= NOW()");
        $stmt->execute([$token]);
        $uye = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$uye) {
            alert("Hata", "Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı. Lütfen tekrar talep edin.", "error");
            exit;
        }

        $hash_sifre = password_hash($yeni_sifre, PASSWORD_DEFAULT);

        $guncelle = $db->prepare("UPDATE i_uyeler SET uye_sifre = ?, sifre_kod = NULL, sifre_kod_tarih = NULL WHERE uye_id = ?");
        $guncelle->execute([$hash_sifre, $uye['uye_id']]);

        if (function_exists('sistemLogEkle')) {
            sistemLogEkle($db, 'PASSWORD_RESET', 'Şifre Güncellendi', "Üye ID: {$uye['uye_id']} başarıyla yeni şifresini belirledi.");
        }

        alert(null, URL . 'giris');
        exit;
    }

} else {
    header("Location:" . URL . "404");
    exit;
}