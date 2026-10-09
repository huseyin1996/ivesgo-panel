<?php 
require_once 'ayar.php';

// Eğer oturum yoksa ama Beni Hatırla çerezi (cookie) varsa
if (!isset($_SESSION['uye_id']) && isset($_COOKIE['user_remember_token'])) {
    $token = $_COOKIE['user_remember_token'];
    
    $sorgu = $db->prepare("SELECT * FROM i_uyeler WHERE remember_token = ? AND uye_onay = 1");
    $sorgu->execute([$token]);
    
    if ($sorgu->rowCount() > 0) {
        $uye = $sorgu->fetch(PDO::FETCH_ASSOC);
        
        // Oturumları otomatik başlat
        $_SESSION["uye_id"]        = $uye['uye_id'];
        $_SESSION["uye_ad_soyad"]  = $uye['uye_ad_soyad'];
        $_SESSION["uye_eposta"]    = $uye['uye_eposta'];
        $_SESSION["uye_onay"]      = 1;
        $_SESSION["uye_rutbe"]     = $uye['uye_rutbe'];
        
        $yeni_token = md5(uniqid(mt_rand(), true));
        $_SESSION["giris_token"]   = $yeni_token;
        
        $db->prepare("UPDATE i_uyeler SET giris_token = ? WHERE uye_id = ?")->execute([$yeni_token, $uye['uye_id']]);
    }
}


function p($par, $st = false) {
    $val = trim($_POST[$par] ?? ''); 
    if ($st) {
        return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
    }
    return $val;
}

function g($par) {
    return htmlspecialchars(trim($_GET[$par] ?? ''), ENT_QUOTES, 'UTF-8');
}

// Route (URL) Yönlendirme Ayarları
$act_kontrol = $_GET["act"] ?? "index";
$par = array_filter(explode("/", $act_kontrol));
$par = array_values($par); // Indexleri sıfırla
$pages = $par[0] ?? 'index';





/**
 * Fiyat Formatlama
 */
function fiyat($fiyat, $indirim = null) {
    $fiyat = (float) $fiyat;
    if (!empty($indirim) && $indirim > 0) {
        $fiyat = $fiyat - (($fiyat / 100) * (float)$indirim);
    }
    return number_format($fiyat, 2, ',', '.') . ' ₺';
}

/**
 * Sepet İşlemleri
 */
function sepetim() {
    global $db, $ayar;
    $rsp = ["sepet" => ["urunler" => [], "ara_toplam" => 0, "toplam" => 0, "genel_toplam" => 0]];
    
    $uye_id = $_SESSION['cari'] ?? null;
    
    if ($uye_id) {
        $sepet_kontrol = $db->prepare("SELECT * FROM i_sepet INNER JOIN i_urunler ON sepet_urun=urun_id WHERE sepet_uye = ?");
        $sepet_kontrol->execute([$uye_id]);
        
        if ($sepet_kontrol->rowCount()) {
            foreach ($sepet_kontrol as $sepet_row) {
                $urun_id = $sepet_row['sepet_urun'];
                
                $urun_varmi = $db->prepare("SELECT * FROM i_urunler WHERE urun_id = ?");
                $urun_varmi->execute([$urun_id]);
                
                if ($urun_varmi->rowCount()) {
                    $urun_cek = $urun_varmi->fetch();
                    
                    $resim_sorgu = $db->prepare("SELECT * FROM i_urun_resimler WHERE urun_id = ? LIMIT 1");
                    $resim_sorgu->execute([$urun_cek["urun_id"]]);
                    $resim_cek = $resim_sorgu->fetch();
                    
                    $resim_yolu = "assets/images/urunler/" . ($resim_cek['resim'] ?? '');
                    $resim = (!empty($resim_cek['resim']) && file_exists($resim_yolu)) ? $resim_yolu : 'assets/images/resim-yok.png';
                    
                    $urun_url = "urun/" . $urun_cek["urun_url"] . "/";
                    $fiyat = ($urun_cek['urun_indirim'] > 0) ? $urun_cek['urun_indirim'] : $urun_cek['urun_fiyat'];
                    
                    $rsp["sepet"]["urunler"][] = [
                        "sepet_id"      => $sepet_row['sepet_id'],
                        "id"            => $urun_cek['urun_id'],
                        "adi"           => $urun_cek["urun_adi"],
                        "stok_kodu"     => $urun_cek["stok_kodu"],
                        "adet"          => $sepet_row["sepet_adet"],
                        "kategori"      => $urun_cek['urun_kategori'],
                        "resim"         => $resim,
                        "url"           => $urun_url,
                        "fiyat"         => $fiyat,
                        "kdv"           => $urun_cek['urun_kdv']
                    ];

                    $araToplam = $fiyat * $sepet_row["sepet_adet"];
                    $rsp["sepet"]["ara_toplam"] += $araToplam; 
                    $rsp["sepet"]["toplam"] += $araToplam;
                }
            }
            $rsp["sepet"]["genel_toplam"] = $rsp["sepet"]["toplam"];
        }
    }
    return (!empty($rsp["sepet"]["urunler"])) ? $rsp : null;
}

/**
 * URL (Slug) Oluşturucu
 */
function sef_link($string) {
    $find = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#'];
    $replace = ['c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp'];
    $string = mb_strtolower(str_replace($find, $replace, $string), 'UTF-8');
    $string = preg_replace("@[^a-z0-9\-_\.\+]@i", ' ', $string);
    $string = trim(preg_replace('/\s+/', ' ', $string));
    return str_replace([' ', '.'], ['-', ''], $string);
}

/**
 * AJAX JSON Uyarı Sistemi
 */
function alert($title = null, $message = null, $type = null, $reload = null, $url = null) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "title" => $title,
        "message" => $message,
        "type" => $type,
        "reload" => $reload,
        "url" => $url
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Tarih Çevirici (Türkçe)
 */
function tarih($par) {
    if(empty($par) || strlen($par) < 10) return "";
    $ay = substr($par, 5, 2);
    $eski_ay = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    $yeni_ay = ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"];
    return substr($par, 8, 2) . ' ' . str_replace($eski_ay, $yeni_ay, $ay) . ' ' . substr($par, 0, 4);
}

function tarihSaat($par){
    $ay         = substr($par,5,2);
    $eski_ay    = array("01","02","03","04","05","06","07","08","09","10","11","12");
    $yeni_ay    = array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
    
    $gun        = substr($par,8,2);
    $saat_dakika= substr($par,11,5);

    return $gun.' '.str_replace($eski_ay,$yeni_ay,$ay).' '.substr($par,0,4).' '.$saat_dakika;
}

function session_olustur($par) {
    if(is_array($par)){
        foreach($par as $anahtar => $deger){
            $_SESSION[$anahtar] = $deger;
        }
    }
}

/**
 * Üye Giriş Kontrolleri
 */
function giris_varmi() {
    global $db, $giris_cek;
    
    if (isset($_SESSION["uye_eposta"], $_SESSION["uye_onay"], $_SESSION["uye_rutbe"])) {
        $uye_kontrol = $db->prepare("SELECT * FROM i_uyeler WHERE (uye_eposta = :eposta) AND uye_rutbe = :rutbe");
        $uye_kontrol->execute([
            ":eposta"   => $_SESSION["uye_eposta"],
            ":rutbe"    => $_SESSION["uye_rutbe"]
        ]);

        if ($uye_kontrol->rowCount() > 0) {
            $giris_cek = $uye_kontrol->fetch();
            return true;
        }
    }
    return false;
}

function giris_yonlendir() {
    global $par, $front_pages;
    if (!giris_varmi()) {
        if ($par[0] != "giris" && !in_array($par[0], $front_pages)) {
            header("Location:" . ADMIN_URL . "giris");
            exit;
        }
    } else {
        if ($par[0] == "giris") {
            header("Location:" . ADMIN_URL . "index");
            exit;
        }
    }
}
    
function uye_cek($uye_eposta = null, $uye_id = null) {
    global $db;
    if ($uye_eposta) {
        $uye_varmi = $db->prepare("SELECT * FROM i_uyeler WHERE uye_eposta = ?");
        $uye_varmi->execute([$uye_eposta]);
    } else if ($uye_id) {
        $uye_varmi = $db->prepare("SELECT * FROM i_uyeler WHERE uye_id = ?");
        $uye_varmi->execute([$uye_id]);
    } else {
        return null;
    }
    
    return $uye_varmi->rowCount() ? $uye_varmi->fetch() : "Üye Bulunamadı";
}

function yetkisiVarMi($modul, $islem) {
    global $giris_cek;
    
    if (isset($giris_cek['uye_rutbe']) && ($giris_cek['uye_rutbe'] == 1)) {
        return true;
    }

    $izinlerJson = $giris_cek['izinler'] ?? '';
    $izinler = json_decode($izinlerJson, true);

    if (isset($izinler[$modul][$islem]) && $izinler[$modul][$islem] == 1) {
        return true;
    }

    return false;
}

/**
 * Güvenli Rastgele Metin/Sayı Üretimi
 */
function RandomString($length = 10) {
    return bin2hex(random_bytes($length / 2));
}

function Randomnumber($length = 8) {
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $result .= random_int(0, 9);
    }
    return $result;
}

/**
 * Dil Ayarları ve Çeviri Blokları
 */
$dil_sec = $_GET['dil'] ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'tr', 0, 2);
$_SESSION["dil"] = ($dil_sec === "ru") ? "ru_" : "";

$lehce = $_SESSION["dil"];
$dil = [];
$bloklar = [];

if (!empty($ayar[$lehce . "dil_ayarlari"])) {
    $arr = json_decode($ayar[$lehce . "dil_ayarlari"], true);
    if (is_array($arr)) {
        foreach ($arr as $cek) {
            $dil[$cek["title"]] = $cek["value"];
            $bloklar[$cek["title"]] = $cek["value"];
        }
    }
}

$site_iletisim = [];
if (!empty($ayar["site_iletisim"])) {
    $arr = json_decode($ayar["site_iletisim"], true);
    if (is_array($arr)) {
        foreach ($arr as $cek) {
            $site_iletisim[$cek["tip"]] = $cek["value"];
        }
    }
}

function redirect_404() {
    header("Location:" . URL . "404");
    exit;
}

/**
 * Sipariş Durumu
 */
function siparis_durum($status) {
    $durumlar = [
        8 => ["message" => "Onayda bekleniyor.", "icon" => "clock", "alert" => "warning"],
        1 => ["message" => "Siparişiniz hazırlanıyor...", "icon" => "clock", "alert" => "success"],
        2 => ["message" => "Siparişiniz kargoya verildi.", "icon" => "check", "alert" => "success"],
        3 => ["message" => "Siparişiniz teslim edildi.", "icon" => "check", "alert" => "success"],
        4 => ["message" => "Siparişiniz iptal edildi.", "icon" => "x-circle", "alert" => "danger"],
        5 => ["message" => "EFT/Havale ile ödeme bekleniyor.", "icon" => "clock", "alert" => "warning"],
        6 => ["message" => "Kapıda Ödeme ile ödeme bekleniyor.", "icon" => "clock", "alert" => "info"],
        7 => ["message" => "Kapıda Kredi Kartı ile ödeme bekleniyor.", "icon" => "clock", "alert" => "info"],
        8 => ["message" => "Kredi Kartı ile Ödeme Başarısız Oldu.", "icon" => "clock", "alert" => "warning"]
    ];
    
    return $durumlar[$status] ?? ["message" => "Bilinmeyen Durum", "icon" => "rotate-cw", "alert" => "secondary"];
}


function ilce($id) {
    global $db;
    $ilce_cek = $db->prepare("SELECT * FROM ilceler WHERE ilce_id = ?");
    $ilce_cek->execute([$id]);
    $res = $ilce_cek->fetch();
    return $res["ilce_adi"] ?? '';
}

function GetIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    return trim($ip);
}

//Modül Kontrolü
function modulAktifMi($db, $modulAdi) {
    $stmt = $db->query("SELECT modul_ayarlari FROM i_ayar LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || empty($row['modul_ayarlari'])) {
        return false;
    }

    $moduller = json_decode($row['modul_ayarlari'], true);

    return isset($moduller[$modulAdi]) && ($moduller[$modulAdi] == "1" || $moduller[$modulAdi] === 1);
}

// 2. KRİTİK STOKLARI GETİRME FONKSİYONU

function kritikStoklariGetir($db) {
    if (!modulAktifMi($db, 'stok_alarm_sistemi')) {
        return [];
    }

    $kritikSinir = 10;

    $stmt = $db->prepare("
        SELECT u.*, k.kategori_adi, r.resim 
        FROM i_urunler u 
        LEFT JOIN i_kategoriler k ON u.urun_kategori = k.id 
        LEFT JOIN i_urun_resimler r ON u.urun_id = r.id 
        WHERE u.urun_stok <= ? 
        ORDER BY u.urun_stok ASC 
        LIMIT 10
    ");
    $stmt->execute([$kritikSinir]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function MailGonder($db, $konu, $aciklama, $ozelAlici = null) {
    
    global $ayar, $bloklar, $site_iletisim; 

    if (!$ayar || empty($ayar['mail_ayarlari'])) {
        return false;
    }

    $mailAyarlari = json_decode($ayar['mail_ayarlari'], true);

    $host   = $mailAyarlari['host'] ?? 'mail.ivesgo.com';
    $port   = $mailAyarlari['port'] ?? 465;
    $user   = $mailAyarlari['user'] ?? 'send@ivesgo.com';
    $pass   = $mailAyarlari['pass'] ?? '';
    $anaAlici = $mailAyarlari['alici'] ?? 'destek@ivesgo.com';
    $isim   = $mailAyarlari['isim'] ?? $bloklar['firma_adi'];

    $hedefAlici = !empty($ozelAlici) ? $ozelAlici : $anaAlici;

    require_once 'Mailler/Exception.php';
    require_once 'Mailler/PHPMailer.php';
    require_once 'Mailler/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host       = $host;
        $mail->Port       = $port;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($user, $isim);
        $mail->addAddress($hedefAlici, $bloklar['firma_adi']);

        ob_start();
        include 'Mailler/Template.php';
        $mesajGovdesi = ob_get_clean();

        $mail->isHTML(true);
        $mail->Subject = $konu;
        $mail->MsgHTML($ileti);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function XMLPOST($PostAddress,$xmlData)
{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$PostAddress);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        $result = curl_exec($ch);
        return $result;
}


function smsGonder($db, $sms_telefon, $sms_text) {
    global $ayar;
    if (!function_exists('modulAktifMi') || !modulAktifMi($db, 'sms_bildirimleri')) {
        return false;
    }


    if (!$ayar || empty($ayar['sms_ayarlari'])) {
        return false;
    }

    $smsAyarlari = json_decode($ayar['sms_ayarlari'], true);

    $firma      = strtolower(trim($smsAyarlari['firma'] ?? 'netgsm'));
    $kullanici  = trim($smsAyarlari['kullanici'] ?? '');
    $sifre      = trim($smsAyarlari['sifre'] ?? '');
    $baslik     = trim($smsAyarlari['baslik'] ?? 'IVESGO');

    if (empty($kullanici) || empty($sifre)) {
        return false;
    }

    $telefon = preg_replace('/[^0-9]/', '', $sms_telefon);

    try {
        if ($firma === '0') {
            return false;
        }elseif ($firma === 'netgsm') {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <mainbody>
                <header>
                    <company dil="TR">Netgsm</company>
                    <usercode>' . $kullanici . '</usercode>
                    <password>' . $sifre . '</password>
                    <type>1:n</type>
                    <msgheader>' . $baslik . '</msgheader>
                </header>
                <body>
                    <msg><![CDATA[' . $sms_text . ']]></msg>
                    <no>' . $telefon . '</no>
                </body>
            </mainbody>';

            if (function_exists('XMLPOST')) {
                XMLPOST('https://api.netgsm.com.tr/sms/send/xml', $xml);
            }

        } elseif ($firma === 'iletimerkezi') {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <request>
                <authentication>
                    <username>' . $kullanici . '</username>
                    <password>' . $sifre . '</password>
                </authentication>
                <order>
                    <sender>' . $baslik . '</sender>
                    <sendDateTime></sendDateTime>
                    <message>
                        <text><![CDATA[' . $sms_text . ']]></text>
                        <receipients>
                            <gsm>' . $telefon . '</gsm>
                        </receipients>
                    </message>
                </order>
            </request>';

            if (function_exists('XMLPOST')) {
                XMLPOST('https://api.iletimerkezi.com/v1/send-sms', $xml);
            }

        } elseif ($firma === 'mutlucell') {
            
            $xml = '<\?xml version="1.0" encoding="UTF-8"\?>
            <k1:rapor xmlns:k1="http://www.mutlucell.com">
                <k1: kullanıcı adı>' . $kullanici . '</k1: kullanıcı adı>
                <k1:sifre>' . $sifre . '</k1:sifre>
                <k1:telno>' . $telefon . '</k1:telno>
                <k1:mesaj>' . $sms_text . '</k1:mesaj>
                <k1:baslik>' . $baslik . '</k1:baslik>
            </k1:rapor>';
            
            if (function_exists('XMLPOST')) {
                XMLPOST('https://sapi.mutlucell.com/smsgonder1', $xml);
            }
        }

        return true;

    } catch (\Throwable $e) {
        //error_log("[smsGonder] SMS gönderilemedi (" . $firma . "): " . $e->getMessage());
        return false;
    }
}


function bildirimEkle($db, $baslik, $mesaj, $personel_id = null, $tip = 'info', $link = null) {
    try {
        $stmt = $db->prepare("
            INSERT INTO i_bildirimler (personel_id, baslik, mesaj, tip, link, tarih) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        return $stmt->execute([$personel_id, $baslik, $mesaj, $tip, $link]);
    } catch (Throwable $e) {
        return false;
    }
}

function stok_dus($takip_no) {
    global $db;
    
    $siparis_varmi = $db->prepare("SELECT urunler FROM i_siparisler WHERE takip_no = ?");
    $siparis_varmi->execute([$takip_no]);
    
    if ($siparis_varmi->rowCount()) {
        $siparis_cek = $siparis_varmi->fetch(PDO::FETCH_ASSOC);
        
        $urun_listesi = json_decode($siparis_cek["urunler"], true);
        
        if (!empty($urun_listesi) && is_array($urun_listesi)) {
            foreach ($urun_listesi as $urun) {
                $adet = (int) ($urun["adet"] ?? 1);
                $urun_id = $urun["id"] ?? 0;
                
                $urun_varmi = $db->prepare("SELECT urun_id, urun_adi, urun_stok FROM i_urunler WHERE urun_id = ?");
                $urun_varmi->execute([$urun_id]);
                
                if ($urun_varmi->rowCount()) {
                    $urun_cek = $urun_varmi->fetch(PDO::FETCH_ASSOC);
                    $urun_stok = (int) $urun_cek["urun_stok"];
                    
                    if ($urun_stok >= $adet) {
                        $kalan_adet = $urun_stok - $adet;
                        
                        // Stok Güncelleme
                        $update = $db->prepare("UPDATE i_urunler SET urun_stok = ? WHERE urun_id = ?");
                        $update->execute([$kalan_adet, $urun_cek["urun_id"]]);
                        
                        $kritikSinir = 10; 
                        
                        if ($kalan_adet <= $kritikSinir) {
                            
                            // 1. Yönetim Paneli Bildirim Merkezine Ekleme (i_bildirimler)
                            $bildirimBaslik = "Kritik Stok Uyarısı!";
                            $bildirimMesaj  = "'" . $urun_cek["urun_adi"] . "' adlı ürünün stoğu kritik seviyeye düştü! Kalan Stok: " . $kalan_adet . " Adet";
                            
                            $stmtBildirim = $db->prepare("INSERT INTO i_bildirimler (baslik, mesaj, tip) VALUES (?, ?, ?)");
                            $stmtBildirim->execute([$bildirimBaslik, $bildirimMesaj, 'stok']);

                            if (function_exists('modulAktifMi') && modulAktifMi($db, 'stok_alarm_sistemi')) {
                                $konu = "Kritik Stok Uyarısı: " . $urun_cek["urun_adi"];
                                $aciklama = "<h2>Kritik Stok Uyarısı</h2>";
                                $aciklama .= "<p><b>'" . htmlspecialchars($urun_cek["urun_adi"]) . "'</b> adlı ürünün stoğu kritik seviyenin altına düşmüştür.</p>";
                                $aciklama .= "<p><b>Güncel Kalan Stok Miktarı:</b> " . $kalan_adet . " Adet</p>";
                                $aciklama .= "<p>Lütfen yönetim paneli üzerinden stokları kontrol ediniz.</p>";

                                if (function_exists('MailGonder')) {
                                    MailGonder($db, $konu, $aciklama);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

/**
 * Yüzde Hesaplama (Division by Zero Korumalı)
 */
function yuzdeHesaplama($indirim_fiyat, $norma_fiyat) {
    $indirim_fiyat = (float) $indirim_fiyat;
    $norma_fiyat = (float) $norma_fiyat;
    
    if ($indirim_fiyat <= 0) return 0;
    
    $yuzde_hesapla = 1 - ($norma_fiyat / $indirim_fiyat);
    return round($yuzde_hesapla * 100);
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"] ?? '');
}



function resim_yukle($file_array, $hedef_klasor, $on_ek_isim = 'img_', $ana_genislik = 1400, $thumb_genislik = 450, $thumb_yukseklik = 280) {
    global $bloklar; 
    
    if (!class_exists('\Verot\Upload\Upload')) {
        require_once 'class.upload.php'; 
    }

    $handle = new \Verot\Upload\Upload($file_array, 'tr_TR');
    
    if ($handle->uploaded) {
        $on_ek = !empty($bloklar['resim_on_ek']) ? $bloklar['resim_on_ek'] : $on_ek_isim;
        $benzersiz_isim = uniqid($on_ek);
        $veritabanina_yazilacak_ad = '';
        
        $handle->file_new_name_body       = $benzersiz_isim;
        $handle->image_resize             = true;
        $handle->image_x                  = $ana_genislik;
        $handle->image_ratio_y            = true;
        $handle->image_ratio_no_zoom_in   = true;
        $handle->process($hedef_klasor);
        
        if ($handle->processed) {
            $veritabanina_yazilacak_ad = $handle->file_dst_name; 
        }

        if ($thumb_genislik > 0 && $thumb_yukseklik > 0) {
            $handle->file_new_name_body       = $benzersiz_isim;
            $handle->image_resize             = true;
            $handle->image_x                  = $thumb_genislik; 
            $handle->image_y                  = $thumb_yukseklik;
            $handle->image_ratio_crop         = true;
            $handle->process($hedef_klasor . 'thumb/');
        }

        $handle->file_new_name_body       = $benzersiz_isim;
        $handle->image_resize             = true;
        $handle->image_x                  = $ana_genislik;
        $handle->image_ratio_y            = true;
        $handle->image_ratio_no_zoom_in   = true;
        $handle->image_convert            = 'webp';
        $handle->webp_quality             = 85;
        $handle->process($hedef_klasor);
        
        
        if ($thumb_genislik > 0 && $thumb_yukseklik > 0) {
            $handle->file_new_name_body       = $benzersiz_isim;
            $handle->image_resize             = true;
            $handle->image_x                  = $thumb_genislik; 
            $handle->image_y                  = $thumb_yukseklik;
            $handle->image_ratio_crop         = true;
            $handle->image_convert            = 'webp';
            $handle->webp_quality             = 80;
            $handle->process($hedef_klasor . 'thumb/');
        }
        
        $handle->clean();
        return $veritabanina_yazilacak_ad; 
    }
    return null;
}

function resim_sil($dosya_adi, $klasor_yolu) {
    if (!empty($dosya_adi)) {
        $webp_adi = pathinfo($dosya_adi, PATHINFO_FILENAME) . '.webp';
        
        @unlink($klasor_yolu . $dosya_adi);             
        @unlink($klasor_yolu . 'thumb/' . $dosya_adi);  

        @unlink($klasor_yolu . $webp_adi);              
        @unlink($klasor_yolu . 'thumb/' . $webp_adi);   
    }
}

function resimGetir($path, $name, $varsayilan = 'assets/images/resim-yok.png') {
    if (empty($name)) {
        return $defaultImage;
    }

    $webYolu = 'assets/images/' . trim($path, '/') . '/' . ltrim($name, '/');
    
    if (file_exists($webYolu) && is_file($webYolu)) {
        return $webYolu;
    }

    return $defaultImage;
}

function resimVarmi($path, $name) {
    $defaultImage = "assets/images/system/gorsel-hazirlaniyor.jpg";
    
    if (empty($name)) {
        return false;
    }

    $webYolu = 'assets/images/' . trim($path, '/') . '/' . ltrim($name, '/');
    
    if (file_exists($webYolu) && is_file($webYolu)) {
        return true;
    }
}

function sistemLogEkle($db, $islem_turu, $modul, $aciklama) {
    $personel_id = $_SESSION['uye_id'];
    
    $ip_adresi = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_adresi = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_adresi = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    try {
        $stmt = $db->prepare("INSERT INTO system_logs (personel_id, islem_turu, modul, aciklama, ip_adresi) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$personel_id, $islem_turu, $modul, $aciklama, $ip_adresi]);
    } catch (Exception $e) {
        echo "Loglama Hatası: " . $e->getMessage();
    }
}

function phoneClear($telefon) {
    return preg_replace('/[\s()+-]/', '', $telefon);
}

function sabit_resim_verisi(string $name) {
    static $sabitResimCache = [];

    if (array_key_exists($name, $sabitResimCache)) {
        return $sabitResimCache[$name];
    }

    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM i_sabit_resimler WHERE resim_adi = ? LIMIT 1");
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $sabitResimCache[$name] = $data ? $data : null;
        return $sabitResimCache[$name];
    } catch (Exception $e) {
        return null;
    }
}

function sabit_resimler(string $name, ?string $alt = null, string $class = '', array $options = []): ?string {
    global $bloklar;

    $resim_cek = sabit_resim_verisi($name);
    if (!$resim_cek || empty($resim_cek["resim"])) {
        return null;
    }

    $dosyaAdi = $resim_cek["resim"];
    $dizin = "assets/images/systems/";
    $resimYolu = $dizin . $dosyaAdi;
    $webpYolu  = $dizin . pathinfo($dosyaAdi, PATHINFO_FILENAME) . ".webp";

    $altText = $alt ?? ($bloklar['firma_adi'] ?? '');

    return resim_picture($webpYolu, $resimYolu, $altText, $class, $options);
}

function resim_picture(
    string $webp,
    string $resim,
    string $alt = '',
    string $class = '',
    array $options = []
): string {
    static $boyutCache = [];

    $defaults = [
        'class'         => 'img-fluid lazyload',
        'lazy'          => true,
        'width'         => null,
        'height'        => null,
        'sizes'         => null,
        'title'         => null,
        'id'            => null,
        'fetchpriority' => null,
        'placeholder'   => 'assets/images/placeholder.svg',
        'check_webp'    => true,
    ];

    $opt=array_merge($defaults,$options);

    if($class!==''){
        $opt['class']=trim($opt['class'].' '.$class);
    }

    $width=(int)($opt['width']??0);
    $height=(int)($opt['height']??0);

    if((!$width||!$height)&&$resim!==''){
        if(!array_key_exists($resim,$boyutCache)){
            $boyutCache[$resim]=false;

            if(file_exists($resim)){
                $olcu=@getimagesize($resim);

                if($olcu&&!empty($olcu[0])&&!empty($olcu[1])){
                    $boyutCache[$resim]=[(int)$olcu[0],(int)$olcu[1]];
                }
            }
        }

        if($boyutCache[$resim]){
            $width=$width?:$boyutCache[$resim][0];
            $height=$height?:$boyutCache[$resim][1];
        }
    }

    $esc=static function($value):string{
        return htmlspecialchars((string)$value,ENT_QUOTES,'UTF-8');
    };

    $webpVar=($opt['check_webp']&&$webp!==''&&file_exists($webp))?$webp:null;

    $dimensionAttr=($width>0&&$height>0)
        ?' width="'.$width.'" height="'.$height.'"'
        :'';

    $sizesAttr=!empty($opt['sizes'])
        ?' sizes="'.$esc($opt['sizes']).'"'
        :'';

    $extraAttrs='';

    if(!empty($opt['title'])){
        $extraAttrs.=' title="'.$esc($opt['title']).'"';
    }

    if(!empty($opt['id'])){
        $extraAttrs.=' id="'.$esc($opt['id']).'"';
    }

    if(!empty($opt['fetchpriority'])){
        $extraAttrs.=' fetchpriority="'.$esc($opt['fetchpriority']).'"';
    }

    $html='<picture>';

    if($webpVar){
        if($opt['lazy']){
            $html.='<source data-srcset="'.$esc($webpVar).'" type="image/webp"'.$sizesAttr.'>';
        }else{
            $html.='<source srcset="'.$esc($webpVar).'" type="image/webp"'.$sizesAttr.'>';
        }
    }

    if($opt['lazy']){
        $html.='<source data-srcset="'.$esc($resim).'" type="image/jpeg"'.$sizesAttr.'>';
        $html.='<img class="'.$esc($opt['class']).'" src="'.$esc($opt['placeholder']).'" data-src="'.$esc($resim).'" loading="lazy" decoding="async" alt="'.$esc($alt).'"'.$dimensionAttr.$extraAttrs.'>';
    }else{
        $html.='<source srcset="'.$esc($resim).'" type="image/jpeg"'.$sizesAttr.'>';
        $html.='<img class="'.$esc($opt['class']).'" src="'.$esc($resim).'" loading="eager" decoding="async" alt="'.$esc($alt).'"'.$dimensionAttr.$extraAttrs.'>';
    }

    $html.='</picture>';

    return $html;
}

function resim_cek($name) {
    global $db;
    $resim_varmi = $db->prepare("SELECT * FROM i_sabit_resimler WHERE resim_adi = ?");
    $resim_varmi->execute([$name]);
    if ($resim_varmi) {
        $resim_cek = $resim_varmi->fetch(PDO::FETCH_ASSOC);
        if (!empty($resim_cek["resim"])) {
            return "assets/images/systems/" . $resim_cek["resim_webp"];
        }
    }
    return null;
}



/*
SOE AYARLARI
*/


function seo_rota_anahtari($slug) {
    global $url_alias;
    if ($slug === '') {
        return '';
    }

    foreach ($url_alias as $liste) {
        $bulunan = array_search($slug, $liste, true);
        if ($bulunan !== false) {
            return $bulunan;
        }
    }
    return '';
}

function seo_temizle($metin, $limit = 0) {
    $metin = preg_replace('/<[^>]*>/', ' ', (string)$metin);
    $metin = html_entity_decode($metin, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $temiz = preg_replace('/\s+/u', ' ', $metin);
    $metin = trim($temiz !== null ? $temiz : $metin);

    if ($limit > 0 && mb_strlen($metin, 'UTF-8') > $limit) {
        $metin = mb_substr($metin, 0, $limit - 1, 'UTF-8');
        $kes = preg_replace('/\s+\S*$/u', '', $metin);
        $metin = rtrim($kes !== null ? $kes : $metin, " ,.;:-") . '…';
    }
    return $metin;
}

function seo_alan($kayit, $onek, $kolon) {
    $v = isset($kayit[$onek . $kolon]) ? trim((string)$kayit[$onek . $kolon]) : '';
    if ($v === '' && $onek !== '') {
        $v = isset($kayit[$kolon]) ? trim((string)$kayit[$kolon]) : '';
    }
    return $v;
}

function seo_title_olustur($baslik, $siteBaslik) {
    if ($baslik === '') {
        return $siteBaslik;
    }
    if ($siteBaslik === '' || mb_stripos($baslik, $siteBaslik, 0, 'UTF-8') !== false) {
        return $baslik;
    }
    return $baslik . ' | ' . $siteBaslik;
}

function seo_tarih($deger) {
    $deger = trim((string)$deger);
    if ($deger === '' || strpos($deger, '0000-00-00') === 0) {
        return '';
    }
    try {
        $d = new DateTime($deger);
        return $d->format('c');
    } catch (Exception $e) {
        return '';
    }
}

function seo_gorsel($kayit, array $kolonlar, array $klasorler, $varsayilan) {
    foreach ($kolonlar as $kol) {
        $dosya = isset($kayit[$kol]) ? trim((string)$kayit[$kol]) : '';
        if ($dosya === '') {
            continue;
        }
        foreach ($klasorler as $klasor) {
            if (is_file($klasor . $dosya)) {
                return URL . $klasor . str_replace(' ', '%20', $dosya);
            }
        }
    }
    return $varsayilan;
}

function seo_kayit_getir($tablo, array $slugKolonlari, $durumKolonu, $slug) {
    global $db;
    if ($slug === '' || !$db) {
        return null;
    }
    $parcalar = [];
    foreach ($slugKolonlari as $kolon) {
        $parcalar[] = $kolon . ' = ?';
    }
    $sql = 'SELECT * FROM ' . $tablo . ' WHERE (' . implode(' OR ', $parcalar) . ')';
    if ($durumKolonu) {
        $sql .= ' AND ' . $durumKolonu . ' = 1';
    }
    $sql .= ' LIMIT 1';

    try {
        $st = $db->prepare($sql);
        $st->execute(array_fill(0, count($slugKolonlari), $slug));
        $kayit = $st->fetch(PDO::FETCH_ASSOC);
        return $kayit ? $kayit : null;
    } catch (Throwable $e) {
        error_log('[seo.php] ' . $e->getMessage());
        return null;
    }
}

function seo_alt_urlleri($sayfaAnahtari, $kayit, $slugKolonu) {
    $sonuc = [];
    foreach (['tr' => '', 'en' => 'en_', 'ar' => 'ar_', 'ru' => 'ru_'] as $kod => $onek) {
        $slug = isset($kayit[$onek . $slugKolonu]) ? trim((string)$kayit[$onek . $slugKolonu]) : '';
        if ($slug !== '') {
            $sonuc[$kod] = URL . url_page($sayfaAnahtari, $slug, $kod);
        }
    }
    return $sonuc;
}

function seo_bos_temizle($dizi) {
    if (!is_array($dizi)) {
        return $dizi;
    }
    $liste = !empty($dizi) && array_keys($dizi) === range(0, count($dizi) - 1);
    $sonuc = [];
    foreach ($dizi as $k => $v) {
        if (is_array($v)) {
            $v = seo_bos_temizle($v);
        }
        if ($v === null || $v === '' || $v === []) {
            continue;
        }
        $sonuc[$k] = $v;
    }
    return $liste ? array_values($sonuc) : $sonuc;
}

function seo_json_bayrak() {
    $f = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_PARTIAL_OUTPUT_ON_ERROR;
    if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) {
        $f |= JSON_INVALID_UTF8_SUBSTITUTE;
    }
    return $f;
}

function seo_json_deger($deger) {
    return json_encode($deger, seo_json_bayrak());
}

function seo_json_ld(array $dugumler) {
    $json = json_encode([
        '@context' => 'https://schema.org',
        '@graph'   => array_values(seo_bos_temizle($dugumler)),
    ], seo_json_bayrak());

    return $json === false ? '' : "\n<script type=\"application/ld+json\">" . $json . "</script>\n";
}

function seo_kirinti_dugumu($sayfaUrl, array $ogeler) {
    $liste = [];
    $sira = 1;
    foreach ($ogeler as $oge) {
        if (empty($oge['ad']) || empty($oge['url'])) {
            continue;
        }
        $liste[] = [
            '@type'    => 'ListItem',
            'position' => $sira++,
            'name'     => seo_temizle($oge['ad']),
            'item'     => $oge['url'],
        ];
    }
    if (count($liste) < 2) {
        return null;
    }
    return [
        '@type'           => 'BreadcrumbList',
        '@id'             => $sayfaUrl . '#breadcrumb',
        'itemListElement' => $liste,
    ];
}

function seo_yorumlari_getir($onek) {
    global $db, $seo_yorum_ayar;
    $c = $seo_yorum_ayar;
    $liste = [];

    if (!$db || empty($c['tablo'])) {
        return $liste;
    }
    try {
        $sql = 'SELECT * FROM ' . $c['tablo'];
        if (!empty($c['durum'])) {
            $sql .= ' WHERE ' . $c['durum'] . ' = 1';
        }
        if (!empty($c['tarih'])) {
            $sql .= ' ORDER BY ' . $c['tarih'] . ' DESC';
        }
        $sql .= ' LIMIT 20';

        $st = $db->query($sql);
        if (!$st) {
            return $liste;
        }

        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $isim = seo_temizle(isset($r[$c['isim']]) ? $r[$c['isim']] : '');
            $metin = seo_temizle(seo_alan($r, $onek, $c['metin']));
            $puan = (isset($r[$c['puan']]) && is_numeric($r[$c['puan']])) ? (float)$r[$c['puan']] : 0;

            if ($isim === '' || $metin === '' || $puan < 1 || $puan > 5) {
                continue;
            }
            $liste[] = [
                'isim'  => $isim,
                'metin' => $metin,
                'puan'  => $puan,
                'tarih' => seo_tarih(isset($r[$c['tarih']]) ? $r[$c['tarih']] : ''),
            ];
        }
    } catch (Throwable $e) {
        error_log('[seo.php] yorumlar: ' . $e->getMessage());
    }
    return $liste;
}

function seo_isletme_dugumu(array $yorumlar = []) {
    global $ayar, $bloklar, $site_iletisim, $social_dizi;

    $b   = is_array($bloklar) ? $bloklar : [];
    $tel = '';
    if (is_array($site_iletisim)) {
        $tel = !empty($site_iletisim[1]) ? $site_iletisim[1] : (!empty($site_iletisim[4]) ? $site_iletisim[4] : '');
    }

    $adres = [
        'streetAddress'   => isset($b['schama_adres']) ? $b['schama_adres'] : (isset($b['schema_adres']) ? $b['schema_adres'] : ''),
        'addressLocality' => isset($b['schama_sehir']) ? $b['schama_sehir'] : (isset($b['schema_sehir']) ? $b['schema_sehir'] : ''),
        'postalCode'      => isset($b['schema_posta_kodu']) ? $b['schema_posta_kodu'] : '',
    ];
    $adresVar = ($adres['streetAddress'] !== '' || $adres['addressLocality'] !== '' || $adres['postalCode'] !== '');
    if ($adresVar) {
        $adres = ['@type' => 'PostalAddress'] + $adres + ['addressCountry' => 'TR'];
    }

    $lat = str_replace(',', '.', trim(isset($b['schema_koordinat_1']) ? (string)$b['schema_koordinat_1'] : ''));
    $lon = str_replace(',', '.', trim(isset($b['schema_koordinat_2']) ? (string)$b['schema_koordinat_2'] : ''));
    $geo = (is_numeric($lat) && is_numeric($lon))
        ? ['@type' => 'GeoCoordinates', 'latitude' => (float)$lat, 'longitude' => (float)$lon]
        : null;

    $saatler = [];
    if (!empty($b['schema_hafta_ici_saat_1']) && !empty($b['schema_hafta_ici_saat_2'])) {
        $saatler[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens'     => $b['schema_hafta_ici_saat_1'],
            'closes'    => $b['schema_hafta_ici_saat_2'],
        ];
    }
    if (!empty($b['schema_hafta_sonu_saat_1']) && !empty($b['schema_hafta_sonu_saat_2'])) {
        $saatler[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => 'Saturday',
            'opens'     => $b['schema_hafta_sonu_saat_1'],
            'closes'    => $b['schema_hafta_sonu_saat_2'],
        ];
    }

    $logo = URL . 'assets/images/logo/' . (isset($ayar['logo']) ? $ayar['logo'] : '');

    $dugum = [
        '@type'                     => 'LocalBusiness',
        '@id'                       => URL . '#organization',
        'name'                      => isset($b['firma_adi']) ? $b['firma_adi'] : '',
        'url'                       => URL,
        'image'                     => $logo,
        'logo'                      => ['@type' => 'ImageObject', '@id' => URL . '#logo', 'url' => $logo],
        'telephone'                 => $tel,
        'address'                   => $adresVar ? $adres : null,
        'geo'                       => $geo,
        'openingHoursSpecification' => $saatler,
        'sameAs'                    => is_array($social_dizi) ? $social_dizi : [],
        'contactPoint'              => $tel === '' ? null : [
            '@type'             => 'ContactPoint',
            'telephone'         => $tel,
            'contactType'       => 'customer service',
            'areaServed'        => 'TR',
            'availableLanguage' => ['Turkish', 'English', 'Russian'],
        ],
    ];

    if (!empty($yorumlar)) {
        $toplam = 0;
        $inceleme = [];
        foreach ($yorumlar as $y) {
            $toplam += $y['puan'];
            $inceleme[] = [
                '@type'         => 'Review',
                'author'        => ['@type' => 'Person', 'name' => $y['isim']],
                'reviewBody'    => $y['metin'],
                'datePublished' => $y['tarih'],
                'reviewRating'  => [
                    '@type'       => 'Rating',
                    'ratingValue' => $y['puan'],
                    'bestRating'  => 5,
                    'worstRating' => 1,
                ],
            ];
        }
        $dugum['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => round($toplam / count($yorumlar), 1),
            'reviewCount' => count($yorumlar),
            'bestRating'  => 5,
            'worstRating' => 1,
        ];
        $dugum['review'] = $inceleme;
    }

    return $dugum;
}

/* =====================================================
 * DİL VE BLOK TANIMLAMALARI (HATA GİDERİLDİ)
 * ===================================================== */

$lehce = function_exists('seo_dil_kodu') ? seo_dil_kodu() : 'tr';
$aktifDil = $lehce . '_';

$bloklar = [];
$site_blok_anahtar = ($lehce === 'tr') ? 'site_bloklar' : $lehce . '_site_bloklar';
$arr = json_decode(isset($ayar[$site_blok_anahtar]) ? $ayar[$site_blok_anahtar] : (isset($ayar['site_bloklar']) ? $ayar['site_bloklar'] : '[]'), true);

if (!empty($arr)) {
    foreach ($arr as $cek) {
        $title = isset($cek["title"]) ? $cek["title"] : '';
        $value = isset($cek["value"]) ? $cek["value"] : '';
        $bloklar[$title] = $value;
    }
}

$site_iletisim = [];
$arr = json_decode(isset($ayar["site_iletisim"]) ? $ayar["site_iletisim"] : '[]', true);
if (!empty($arr)) {
    foreach ($arr as $cek) {
        $tip = isset($cek["tip"]) ? $cek["tip"] : '';
        $value = isset($cek["value"]) ? $cek["value"] : '';
        $site_iletisim[$tip] = $value;
    }
}

$sosyal_medya = [];
$arr = json_decode(isset($ayar["site_sosyalmedya"]) ? (string)$ayar["site_sosyalmedya"] : '[]', true);
$social_dizi = [];

if (!empty($arr)) {
    foreach ($arr as $cek) {
        $tip = isset($cek["tip"]) ? $cek["tip"] : '';
        $link = isset($cek['value']) ? trim((string)$cek['value']) : '';
        if ($link !== '' && filter_var($link, FILTER_VALIDATE_URL)) {
            $social_dizi[] = $link;
        }
        $sosyal_medya[$tip] = $link;
    }
}
$social = implode(',', array_map('seo_json_deger', $social_dizi));

/* =====================================================
 * GLOBAL ANAHTAR KELİME
 * ===================================================== */

$anahtar_kelimeler_dizi = [];
foreach (explode(',', isset($ayar['site_keyw']) ? (string)$ayar['site_keyw'] : '') as $kelime) {
    $kelime = trim($kelime);
    if ($kelime !== '') {
        $anahtar_kelimeler_dizi[] = $kelime;
    }
}
if (!empty($bloklar['firma_adi'])) {
    $anahtar_kelimeler_dizi[] = $bloklar['firma_adi'];
}
$anahtar_kelimeler_dizi = array_values(array_unique($anahtar_kelimeler_dizi));
$anahtar_kelimeler = implode(',', array_map('seo_json_deger', $anahtar_kelimeler_dizi));

/* =====================================================
 * URL üretimi
 * ===================================================== */

function url_page($page, $slug = '', $dilKodu = null) {
    global $url_alias;

    $kod = $dilKodu ? $dilKodu : seo_dil_kodu();
    $anahtar = $kod . '_';

    if (!isset($url_alias[$anahtar])) {
        $kod = 'tr';
        $anahtar = 'tr_';
    }

    $onek = ($kod !== 'tr') ? $kod . '/' : '';

    if ($page === 'index') {
        return $onek;
    }

    if (isset($url_alias[$anahtar][$page])) {
        $alias = $url_alias[$anahtar][$page];
    } elseif (isset($url_alias['tr_'][$page])) {
        $alias = $url_alias['tr_'][$page];
    } else {
        return $onek . '404/';
    }

    $yol = $onek . $alias . '/';
    $slug = trim((string)$slug, '/');
    if ($slug !== '') {
        $yol .= $slug . '/';
    }
    return $yol;
}

/* =====================================================
 * sayfa ayarları
 * ===================================================== */


function sayfa_ayarlari() {
    global $par, $ayar, $seo, $bloklar;

    date_default_timezone_set('Europe/Istanbul');

    $kod = seo_dil_kodu();
    $L = ($kod === 'tr') ? '' : $kod . '_';
    $onek = ($kod === 'tr') ? '' : $kod . '/';
    $lokal = seo_locale($kod);

    $p0 = isset($par[0]) ? trim((string)$par[0]) : '';
    $p1 = isset($par[1]) ? trim((string)$par[1]) : '';
    $anasayfaMi = ($p0 === '' || $p0 === 'index');
    $rota = seo_rota_anahtari($p0);

    $siteBaslik = trim((string)(isset($ayar['site_title']) ? $ayar['site_title'] : ''));
    $siteDesc = seo_temizle(isset($ayar['site_desc']) ? $ayar['site_desc'] : '');
    $firma = trim((string)(isset($bloklar['firma_adi']) ? $bloklar['firma_adi'] : ''));
    $logoDosya = (string)(isset($ayar['logo']) ? $ayar['logo'] : '');
    $logoUrl = URL . 'assets/images/logo/' . $logoDosya;
    $lblAnasayfa = !empty($bloklar['anasayfa']) ? $bloklar['anasayfa'] : 'Anasayfa';

    $seo = [
        'baslik'     => $siteBaslik,
        'title'      => $siteBaslik,
        'desc'       => $siteDesc,
        'resim'      => $logoUrl,
        'url'        => URL . $onek,
        'canonical'  => URL . $onek,
        'robots'     => 'index, follow',
        'og_type'    => 'website',
        'date'       => '',
        'schema'     => '',
    ];

    $sabitSlug = $anasayfaMi ? 'index' : $p0;
    $sabitKayit = seo_kayit_getir('i_sabit_sayfalar', ['sayfa_url'], null, $sabitSlug);
    
    $s = null;
    $detay = null;
    $bulunamadi = false;

    if ($p1 !== '' && in_array($rota, ['sayfa', 'hizmet', 'cozum', 'sozlesme'], true)) {
        $detay = seo_kayit_getir('i_sayfalar', ['sayfa_url'], 'sayfa_durum', $p1);

        if ($detay) {
            $ust = [];
            if ($rota === 'hizmet') {
                $ust = ['ad' => isset($bloklar['hizmetlerimiz']) ? $bloklar['hizmetlerimiz'] : '', 'url' => URL . url_page('hizmetler')];
            } elseif ($rota === 'cozum') {
                $ust = ['ad' => isset($bloklar['cozumlerimiz']) ? $bloklar['cozumlerimiz'] : '', 'url' => URL . url_page('cozumler')];
            }

            $bannerBig = !empty($detay['sayfa_banner']) && is_file('assets/images/sayfalar/big/' . $detay['sayfa_banner']);
            $bannerThm = !empty($detay['sayfa_banner']) && is_file('assets/images/sayfalar/thumb/' . $detay['sayfa_banner']);

            $s = [
                'tip'        => in_array($rota, ['hizmet', 'cozum'], true) ? 'Service' : 'WebPage',
                'baslik'     => seo_alan($detay, $L, 'sayfa_adi'),
                'title'      => seo_alan($detay, $L, 'sayfa_title'),
                'desc'       => seo_alan($detay, $L, 'sayfa_desc'),
                'alt'        => seo_alt_urlleri($rota, $detay, 'sayfa_url'),
                'resim'      => seo_gorsel($detay, ['sayfa_resim'], ['assets/images/sayfalar/big/'], $logoUrl),
                'bg_resim'   => $bannerBig ? 'assets/images/sayfalar/big/' . $detay['sayfa_banner'] : $bgVarsayilan,
                'bg_resim_t' => $bannerThm ? 'assets/images/sayfalar/thumb/' . $detay['sayfa_banner'] : $bgVarsayilanT,
                'tarih'      => seo_tarih(isset($detay['sayfa_tarih']) ? $detay['sayfa_tarih'] : ''),
                'ust'        => $ust ? [$ust] : [],
                'og_type'    => 'website',
                'varlik'     => in_array($rota, ['hizmet', 'cozum'], true) ? 'service' : '',
            ];
        } else {
            $bulunamadi = true;
        }
    } elseif ($p1 !== '' && $rota === 'urun') {
        $detay = seo_kayit_getir('i_urunler', ['url'], 'durum', $p1);

        if ($detay) {
            $s = [
                'tip'        => 'WebPage',
                'baslik'     => seo_alan($detay, $L, 'baslik'),
                'title'      => null,
                'desc'       => seo_alan($detay, $L, 'urun_desc'),
                'alt'        => seo_alt_urlleri('urun', $detay, 'url'),
                'resim'      => seo_gorsel($detay, ['urun_banner'], ['assets/images/urunler/'], $logoUrl),
                'bg_resim'   => $bgVarsayilan,
                'bg_resim_t' => $bgVarsayilanT,
                'tarih'      => '',
                'ust'        => [['ad' => isset($bloklar['urunlerimiz']) ? $bloklar['urunlerimiz'] : '', 'url' => URL . url_page('urunler')]],
                'og_type'    => 'product',
                'varlik'     => 'product',
            ];
        } else {
            $bulunamadi = true;
        }
    } elseif ($p1 !== '' && $rota === 'urunler') {
        $detay = seo_kayit_getir('i_kategoriler', ['kategori_url', 'en_kategori_url', 'ru_kategori_url'], 'kategori_durum', $p1);

        if ($detay) {
            $s = [
                'tip'        => 'CollectionPage',
                'baslik'     => seo_alan($detay, $L, 'kategori_adi'),
                'title'      => null,
                'desc'       => seo_alan($detay, $L, 'kategori_desc'),
                'alt'        => seo_alt_urlleri('urunler', $detay, 'kategori_url'),
                'resim'      => seo_gorsel($detay, ['kategori_resim', 'kategori_banner'], ['assets/images/kategoriler/', 'assets/images/kategori/'], $logoUrl),
                'bg_resim'   => $bgVarsayilan,
                'bg_resim_t' => $bgVarsayilanT,
                'tarih'      => seo_tarih(isset($detay['kategori_tarih']) ? $detay['kategori_tarih'] : ''),
                'ust'        => [['ad' => isset($bloklar['urunlerimiz']) ? $bloklar['urunlerimiz'] : '', 'url' => URL . url_page('urunler')]],
                'og_type'    => 'website',
                'varlik'     => '',
            ];
        }
    } elseif ($p1 !== '' && $rota === 'blog') {
        $detay = seo_kayit_getir('i_bloglar', ['blog_url', 'en_blog_url', 'ru_blog_url'], 'blog_durum', $p1);

        if ($detay) {
            $s = [
                'tip'        => 'WebPage',
                'baslik'     => seo_alan($detay, $L, 'blog_baslik'), // Düzeltildi: blog_adi yerine blog_baslik standardı
                'title'      => null,
                'desc'       => seo_alan($detay, $L, 'blog_desc'),
                'alt'        => seo_alt_urlleri('blog', $detay, 'blog_url'),
                'resim'      => seo_gorsel($detay, ['blog_resim', 'blog_banner', 'blog_gorsel'], ['assets/images/bloglar/big/', 'assets/images/bloglar/', 'assets/images/blog/'], $logoUrl),
                'bg_resim'   => $bgVarsayilan,
                'bg_resim_t' => $bgVarsayilanT,
                'tarih'      => seo_tarih(isset($detay['blog_tarih']) ? $detay['blog_tarih'] : ''),
                'ust'        => [['ad' => isset($bloklar['bloglar']) ? $bloklar['bloglar'] : '', 'url' => URL . url_page('blog')]],
                'og_type'    => 'article',
                'varlik'     => 'blog',
            ];
        } else {
            $bulunamadi = false;
        }
    }

    $sabitTrSlug = '';
    if ($s === null && !$bulunamadi) {
        if ($sabitKayit) {
            $sabitTrSlug = (string)$sabitKayit['sayfa_url'];

            $tipHaritasi = [
                'index'             => 'WebPage',
                'iletisim'          => 'ContactPage',
                'tarihce'           => 'AboutPage',
                'hakkimizda'        => 'AboutPage',
                'kurumsal'          => 'AboutPage',
                'sss'               => 'FAQPage',
                'hizmetler'         => 'CollectionPage',
                'cozumler'          => 'CollectionPage',
                'urunler'           => 'CollectionPage',
                'projeler'          => 'CollectionPage',
                'blog'              => 'CollectionPage',
                'referanslar'       => 'CollectionPage',
                'sertifikalar'      => 'CollectionPage',
                'video-galeri'      => 'CollectionPage',
                'galeri'            => 'ImageGallery',
                'musteri-yorumlari' => 'WebPage',
            ];

            $alt = [];
            foreach (['tr' => '', 'en' => 'en_', 'ar' => 'ar_', 'ru' => 'ru_'] as $k => $o) {
                $slug = isset($sabitKayit[$o . 'sayfa_url']) ? trim((string)$sabitKayit[$o . 'sayfa_url']) : '';
                if ($anasayfaMi) {
                    $alt[$k] = URL . ($k === 'tr' ? '' : $k . '/');
                } elseif ($slug !== '') {
                    $alt[$k] = URL . ($k === 'tr' ? '' : $k . '/') . $slug . '/';
                }
            }

            $sabitBg = !empty($sabitKayit['sayfa_resim']) && is_file('assets/images/sabit/big/' . $sabitKayit['sayfa_resim']);
            $sabitBgT = !empty($sabitKayit['sayfa_resim']) && is_file('assets/images/sabit/thumb/' . $sabitKayit['sayfa_resim']);

            $s = [
                'tip'        => isset($tipHaritasi[$sabitTrSlug]) ? $tipHaritasi[$sabitTrSlug] : 'WebPage',
                'baslik'     => seo_alan($sabitKayit, $L, 'baslik'),
                'title'      => seo_alan($sabitKayit, $L, 'title'),
                'desc'       => seo_alan($sabitKayit, $L, 'description'),
                'alt'        => $alt,
                'resim'      => $logoUrl,
                'bg_resim'   => $sabitBg ? 'assets/images/sabit/big/' . $sabitKayit['sayfa_resim'] : $bgVarsayilan,
                'bg_resim_t' => $sabitBgT ? 'assets/images/sabit/thumb/' . $sabitKayit['sayfa_resim'] : $bgVarsayilanT,
                'tarih'      => '',
                'ust'        => [],
                'og_type'    => 'website',
                'varlik'     => '',
            ];
        } elseif ($anasayfaMi) {
            $s = [
                'tip' => 'WebPage', 'baslik' => $siteBaslik, 'title' => $siteBaslik, 'desc' => $siteDesc,
                'alt' => ['tr' => URL, 'en' => URL . 'en/', 'ar' => URL . 'ar/', 'ru' => URL . 'ru/'],
                'resim' => $logoUrl, 'bg_resim' => $bgVarsayilan, 'bg_resim_t' => $bgVarsayilanT,
                'tarih' => '', 'ust' => [], 'og_type' => 'website', 'varlik' => '',
            ];
        }
    }

    if ($bulunamadi || in_array($rota, ['404', 'bakim'], true)) {
        $seo['robots'] = 'noindex, follow';
    }

    $website = [
        '@type'      => 'WebSite',
        '@id'        => URL . '#website',
        'url'        => URL,
        'name'       => $siteBaslik !== '' ? $siteBaslik : $firma,
        'inLanguage' => $lokal,
        'publisher'  => ['@id' => URL . '#organization'],
    ];

    if ($s === null) {
        $seo['schema'] = seo_json_ld([seo_isletme_dugumu(), $website]);
        return $sabitKayit ? $sabitKayit : '';
    }

    $baslik = seo_temizle($s['baslik']);
    $desc = seo_temizle($s['desc'] !== '' ? $s['desc'] : $siteDesc);
    $title = ($s['title'] !== null && $s['title'] !== '') ? $s['title'] : seo_title_olustur($baslik, $siteBaslik);

    $alt = $s['alt'];
    $url = isset($alt[$kod]) ? $alt[$kod] : (isset($alt['tr']) ? $alt['tr'] : URL . $onek . ($p0 !== '' ? $p0 . '/' : ''));

    $seo['baslik'] = $baslik !== '' ? $baslik : $siteBaslik;
    $seo['title'] = $title;
    $seo['desc'] = $desc;
    $seo['resim'] = $s['resim'];
    $seo['bg_resim'] = $s['bg_resim'];
    $seo['bg_resim_t'] = $s['bg_resim_t'];
    $seo['url'] = $url;
    $seo['canonical'] = $url;
    $seo['og_type'] = $s['og_type'];
    $seo['date'] = $s['tarih'];

    $hreflang = '';
    if (!empty($alt)) {
        foreach (['tr' => 'tr-TR', 'en' => 'en-US', 'ar' => 'ar-SA', 'ru' => 'ru-RU'] as $k => $hl) {
            if (isset($alt[$k])) {
                $hreflang .= '<link rel="alternate" hreflang="' . $hl . '" href="' . htmlspecialchars($alt[$k], ENT_QUOTES, 'UTF-8') . '" />' . "\n";
            }
        }
        $xDefault = isset($alt['tr']) ? $alt['tr'] : reset($alt);
        $hreflang .= '<link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($xDefault, ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    }

    $kirintilar = [];
    if (!$anasayfaMi) {
        $kirintilar[] = ['ad' => $lblAnasayfa, 'url' => URL . $onek];
        foreach ($s['ust'] as $ust) {
            $kirintilar[] = $ust;
        }
        $kirintilar[] = ['ad' => $seo['baslik'], 'url' => $url];
    }
    $kirintiDugumu = seo_kirinti_dugumu($url, $kirintilar);

    global $anahtar_kelimeler_dizi;
    $anahtarKelimeler = '';
    if (!empty($anahtar_kelimeler_dizi)) {
        $anahtarKelimeler = implode(', ', $anahtar_kelimeler_dizi);
    }

    $sayfaDugumu = [
        '@type'              => $s['tip'] === 'Service' ? 'WebPage' : $s['tip'],
        '@id'                => $url . '#webpage',
        'url'                => $url,
        'name'               => $seo['title'],
        'description'        => $desc,
        'inLanguage'         => $lokal,
        'isPartOf'           => ['@id' => URL . '#website'],
        'about'              => ['@id' => URL . '#organization'],
        'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $s['resim']],
        'breadcrumb'         => $kirintiDugumu ? ['@id' => $url . '#breadcrumb'] : null,
        'datePublished'      => $s['tarih'],
        'dateModified'       => $s['tarih'],
    ];

    $dugumler = [];
    $yorumlar = [];

    switch ($s['varlik']) {
        case 'service':
            $sayfaDugumu['mainEntity'] = ['@id' => $url . '#service'];
            $dugumler[] = [
                '@type'       => 'Service',
                '@id'         => $url . '#service',
                'name'        => $baslik,
                'description' => $desc,
                'url'         => $url,
                'image'       => $s['resim'],
                'provider'    => ['@id' => URL . '#organization'],
                'areaServed'  => 'TR',
                'inLanguage'  => $lokal,
            ];
            break;

        case 'product':
            $sayfaDugumu['mainEntity'] = ['@id' => $url . '#product'];
            $dugumler[] = [
                '@type'       => 'Product',
                '@id'         => $url . '#product',
                'name'        => $baslik,
                'description' => $desc,
                'url'         => $url,
                'image'       => [$s['resim']],
                'brand'       => ['@type' => 'Brand', 'name' => $firma],
            ];
            break;

        case 'blog':
            $sayfaDugumu['mainEntity'] = ['@id' => $url . '#article'];
            $dugumler[] = [
                '@type'            => 'BlogPosting',
                '@id'              => $url . '#article',
                'mainEntityOfPage' => ['@id' => $url . '#webpage'],
                'headline'         => mb_substr($baslik, 0, 110, 'UTF-8'),
                'description'      => $desc,
                'image'            => [$s['resim']],
                'author'           => ['@id' => URL . '#organization'],
                'publisher'        => ['@id' => URL . '#organization'],
                'datePublished'    => $s['tarih'],
                'dateModified'     => $s['tarih'],
                'keywords'         => $anahtarKelimeler,
                'inLanguage'       => $lokal,
            ];
            break;
    }

    if ($sabitTrSlug === 'sss') {
        global $db;
        $sorular = [];
        try {
            $st = $db->query('SELECT * FROM i_sss WHERE sss_durum = 1');
            if ($st) {
                foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                    $soru = seo_temizle(seo_alan($r, $L, 'sss_soru'));
                    $cevap = seo_temizle(seo_alan($r, $L, 'sss_cevap'));
                    if ($soru === '' || $cevap === '') {
                        continue;
                    }
                    $sorular[] = [
                        '@type'          => 'Question',
                        'name'           => $soru,
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $cevap],
                    ];
                }
            }
        } catch (Throwable $e) {
            error_log('[seo.php] sss: ' . $e->getMessage());
        }
        if (!empty($sorular)) {
            $sayfaDugumu['mainEntity'] = $sorular;
        } else {
            $sayfaDugumu['@type'] = 'WebPage';
        }
    }

    if ($sabitTrSlug === 'musteri-yorumlari') {
        $yorumlar = seo_yorumlari_getir($L);
    }

    $graf = [seo_isletme_dugumu($yorumlar), $website, $sayfaDugumu];
    if ($kirintiDugumu) {
        $graf[] = $kirintiDugumu;
    }
    foreach ($dugumler as $d) {
        $graf[] = $d;
    }

    $seo['schema'] = $hreflang . seo_json_ld($graf);

    if ($sabitKayit) {
        return $sabitKayit;
    }
    return $detay ? $detay : '';
}

