<?php
$data = [];

if(isset($_POST)){
    extract($_POST);

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die(json_encode([
            'type' => 'error', 
            'message' => 'Güvenlik doğrulaması başarısız! (CSRF)'
        ]));
    }
    
    if(!isset($_SESSION["uye_id"])){
        alert("Hata", "Oturum süreniz dolmuş. Lütfen tekrar giriş yapın.", "error");
        exit;
    }

    if(!empty($password)){
        $giris = $db->prepare("SELECT * FROM i_uyeler WHERE uye_id = ?");
        $giris->execute([$_SESSION["uye_id"]]);

        if($giris->rowCount() > 0){
            $bilgi_cek = $giris->fetch(PDO::FETCH_ASSOC);

            if ($bilgi_cek && password_verify($password, $bilgi_cek["uye_sifre"])) {

                if($bilgi_cek["uye_onay"] == 1){
                    
                    unset($_SESSION["is_locked"]);
                    $_SESSION["login_attempts"] = 0;
                    $_SESSION["login_time"] = time();

                    alert(null, URL.'index');

                } else {
                    alert("Hata", "Hesabınız askıya alınmış veya onaylanmamış.", "error");
                }
            } else {
                $_SESSION["login_attempts"] = ($_SESSION["login_attempts"] ?? 0) + 1;
                alert("Hata", "Girdiğiniz şifre hatalı, lütfen kontrol edin.", "error");
            }

        } else {
            alert("Hata", "Kullanıcı kaydı bulunamadı.", "error");
        }
    } else {
        alert("Uyarı", "Lütfen şifre alanını boş bırakmayın.", "warning");
    }
} else {
    header("Location:" . URL . "404");
    exit;
}
?>