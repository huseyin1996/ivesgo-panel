<?php
$uye_id = $_SESSION['uye_id'] ?? $_SESSION['user_id'] ?? null; 

if ($uye_id) {
    $temizle = $db->prepare("UPDATE i_uyeler SET remember_token = NULL, giris_token = NULL WHERE uye_id = ?");
    $temizle->execute([$uye_id]);
}

if (isset($_COOKIE['user_remember_token'])) {
    setcookie('user_remember_token', '', time() - 3600, "/", "", false, true);
}

$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header("Location:".URL);
exit;