<?php

if(isset($_POST)){
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
            exit;
        }
    }

    if ($postType == "Update") {

        $logo_yol         = $ayar['logo'] ?? null;
        $favicon_yol      = $ayar['favicon'] ?? null;
        $koyu_logo_yol    = $ayar['koyu_logo'] ?? null;
        $giris_resim_yol  = $ayar['giris_resim'] ?? null;
        $popup_resim_yol  = $ayar['popup_resim'] ?? null;

        $upload_dir     = 'assets/images/system/';
        $logo_dir       = 'assets/images/logo/';
        $favicon_dir    = 'assets/images/favicon/';
        
        if(!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
        if(!is_dir($logo_dir))   { mkdir($logo_dir, 0755, true); }
        if(!is_dir($favicon_dir)){ mkdir($favicon_dir, 0755, true); }

        // 1. Normal Logo Yükleme
        if(isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] == 0){
            $yukle = resim_yukle($_FILES['logo_file'], $logo_dir, 'logo_');
            if($yukle) {
                if(!empty($ayar['logo']) && file_exists($logo_dir . $ayar['logo'])) {
                    @unlink($logo_dir . $ayar['logo']);
                }
                $logo_yol = $yukle; 
            }
        }

        // 2. Koyu Logo Yükleme (Sorunun yaşandığı alan)
        if(isset($_FILES['koyu_logo']) && $_FILES['koyu_logo']['error'] == 0){
            $yukle = resim_yukle($_FILES['koyu_logo'], $logo_dir, 'koyu_logo_');
            if($yukle) {
                if(!empty($ayar['koyu_logo']) && file_exists($logo_dir . $ayar['koyu_logo'])) {
                    @unlink($logo_dir . $ayar['koyu_logo']);
                }
                $koyu_logo_yol = $yukle;
            }
        }

        // 3. Favicon Yükleme (Verot kütüphanesi)
        if(isset($_FILES['favicon_file']) && $_FILES['favicon_file']['error'] == 0){
            
            if (!class_exists('\Verot\Upload\Upload')) {
                require_once 'system/class.upload.php'; 
            }

            $handle = new \Verot\Upload\Upload($_FILES['favicon_file'], 'tr_TR');
            
            if ($handle->uploaded) {
                $temel_isim = 'favicon_' . uniqid(); 
                
                // 1. Standart Büyük Boy (192x192)
                $handle->file_new_name_body = $temel_isim;
                $handle->image_resize       = true;
                $handle->image_x            = 192;
                $handle->image_y            = 192;
                $handle->image_ratio_crop   = true;
                $handle->process($favicon_dir);

                // 2. 32x32 Boyutu
                $handle->file_new_name_body = $temel_isim . '_32';
                $handle->image_resize       = true;
                $handle->image_x            = 32;
                $handle->image_y            = 32;
                $handle->image_ratio_crop   = true;
                $handle->process($favicon_dir);

                // 3. 16x16 Boyutu
                $handle->file_new_name_body = $temel_isim . '_16';
                $handle->image_resize       = true;
                $handle->image_x            = 16;
                $handle->image_y            = 16;
                $handle->image_ratio_crop   = true;
                $handle->process($favicon_dir);

                // 4. Apple Touch Icon (180x180)
                $handle->file_new_name_body = $temel_isim . '_180';
                $handle->image_resize       = true;
                $handle->image_x            = 180;
                $handle->image_y            = 180;
                $handle->image_ratio_crop   = true;
                $handle->process($favicon_dir);

                // 5. Android Chrome Maskable Icon (512x512)
                $handle->file_new_name_body = $temel_isim . '_512';
                $handle->image_resize       = true;
                $handle->image_x            = 512;
                $handle->image_y            = 512;
                $handle->image_ratio_crop   = true;
                $handle->process($favicon_dir);

                if ($handle->processed) {
                    if (!empty($ayar['favicon'])) {
                        $eskiTemelIsim = pathinfo($ayar['favicon'], PATHINFO_FILENAME);
                        $eskiUzantisi = pathinfo($ayar['favicon'], PATHINFO_EXTENSION);
                        $fizikselKlasor = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/' . $favicon_dir;

                        @unlink($fizikselKlasor . $eskiTemelIsim . '.' . $eskiUzantisi);
                        @unlink($fizikselKlasor . $eskiTemelIsim . '_32.' . $eskiUzantisi);
                        @unlink($fizikselKlasor . $eskiTemelIsim . '_16.' . $eskiUzantisi);
                        @unlink($fizikselKlasor . $eskiTemelIsim . '_180.' . $eskiUzantisi);
                        @unlink($fizikselKlasor . $eskiTemelIsim . '_512.' . $eskiUzantisi);
                    }

                    $favicon_yol = $handle->file_dst_name; 
                }
                
                $handle->clean();
            }
        }

        // 4. Giriş Resim Yükleme
        if(isset($_FILES['giris_resim_file']) && $_FILES['giris_resim_file']['error'] == 0){
            $yukle = resim_yukle($_FILES['giris_resim_file'], $upload_dir, 'giris_');
            if($yukle) {
                if(!empty($ayar['giris_resim']) && file_exists($upload_dir . $ayar['giris_resim'])) {
                    @unlink($upload_dir . $ayar['giris_resim']);
                }
                $giris_resim_yol = $yukle;
            }
        }

        // 5. Popup Resim Yükleme
        if(isset($_FILES['popup_resim_file']) && $_FILES['popup_resim_file']['error'] == 0){
            $yukle = resim_yukle($_FILES['popup_resim_file'], $upload_dir, 'popup_');
            if($yukle) {
                if(!empty($ayar['popup_resim']) && file_exists($upload_dir . $ayar['popup_resim'])) {
                    @unlink($upload_dir . $ayar['popup_resim']);
                }
                $popup_resim_yol = $yukle;
            }
        }

        // JSON Verileri
        $modul_json     = isset($_POST['modul']) ? json_encode($_POST['modul'], JSON_UNESCAPED_UNICODE) : '{}';
        $seo_json       = isset($_POST['seo']) ? json_encode($_POST['seo'], JSON_UNESCAPED_UNICODE) : '{}';
        $sepet_json     = isset($_POST['sepet']) ? json_encode($_POST['sepet'], JSON_UNESCAPED_UNICODE) : '{}';
        $iletisim_json  = isset($_POST['iletisim']) ? json_encode(array_values($_POST['iletisim']), JSON_UNESCAPED_UNICODE) : '[]';
        $sosyal_json    = isset($_POST['sosyal']) ? json_encode(array_values($_POST['sosyal']), JSON_UNESCAPED_UNICODE) : '[]';
        $dil_json       = isset($_POST['dil']) ? json_encode(array_values($_POST['dil']), JSON_UNESCAPED_UNICODE) : '[]';
        $tarihce_json   = isset($_POST['tarihce']) ? json_encode(array_values($_POST['tarihce']), JSON_UNESCAPED_UNICODE) : '[]';
        $banka_json     = isset($_POST['banka']) ? json_encode(array_values($_POST['banka']), JSON_UNESCAPED_UNICODE) : '[]';
        $pos_json       = isset($_POST['pos']) ? json_encode($_POST['pos'], JSON_UNESCAPED_UNICODE) : '{}';
        $mail_json      = isset($_POST['mail']) ? json_encode($_POST['mail'], JSON_UNESCAPED_UNICODE) : '{}';
        $sms_json       = isset($_POST['sms']) ? json_encode($_POST['sms'], JSON_UNESCAPED_UNICODE) : '{}';
        $api_json       = isset($_POST['api']) ? json_encode($_POST['api'], JSON_UNESCAPED_UNICODE) : '{}';
        
        $mevcut_tema_json = json_decode($ayar["tema_ayarlari"] ?? '{}', true);
        $tema_ayar_data = $mevcut_tema_json['tema_ayarlari'] ?? [];

        if (isset($_POST['tema_ayar']) && is_array($_POST['tema_ayar'])) {
            foreach ($_POST['tema_ayar'] as $key => $val) {
                $tema_ayar_data[$key] = trim($val);
            }
        }

        if (isset($_FILES['google_key_json']) && $_FILES['google_key_json']['error'] == 0) {
            $dosya_adi = $_FILES['google_key_json']['name'];
            $uzanti = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));
            $tmp_name = $_FILES['google_key_json']['tmp_name'];

            if ($uzanti === 'json') {
                $icerik = file_get_contents($tmp_name);
                $decode_kontrol = json_decode($icerik, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($decode_kontrol['type']) && $decode_kontrol['type'] === 'service_account' && isset($decode_kontrol['private_key'])) {
                    $hedef_klasor = 'system/';
                    if (!is_dir($hedef_klasor)) { mkdir($hedef_klasor, 0755, true); }
                    
                    $guvenli_isim = 'google-key.json';
                    if (move_uploaded_file($tmp_name, $hedef_klasor . $guvenli_isim)) {
                        $tema_ayar_data['google_key_file'] = $guvenli_isim;
                    }
                } else {
                    die(json_encode(['type' => 'error', 'message' => 'Geçersiz Google Servis Hesabı JSON dosyası!']));
                }
            } else {
                die(json_encode(['type' => 'error', 'message' => 'Sadece .json uzantılı dosya yükleyebilirsiniz!']));
            }
        } else {
            if (isset($mevcut_tema_json['tema_ayar']['google_key_file'])) {
                $tema_ayar_data['google_key_file'] = $mevcut_tema_json['tema_ayar']['google_key_file'];
            }
        }

        $tema_ayar_array = [
            'tema_ayar' => $tema_ayar_data,
            'renkler'   => []
        ];

        if (isset($_POST['renkler']) && is_array($_POST['renkler'])) {
            foreach ($_POST['renkler'] as $item) {
                if (!empty(trim($item['name'] ?? ''))) {
                    $tema_ayar_array['renkler'][] = [
                        'name'  => trim($item['name']),
                        'value' => trim($item['value'] ?? '')
                    ];
                }
            }
        }

        $tema_ayar_json = json_encode($tema_ayar_array, JSON_UNESCAPED_UNICODE);


        if ($modul_json != $ayar['modul_ayarlari'] ) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "Modül ayarları güncellenmiştir.");
        }elseif ($sepet_json != $ayar['sepet_ayarlari']) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "Sepet ayarları güncellenmiştir.");
        }elseif ($banka_json != $ayar['banka_bilgiler']) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "Banka ayarları güncellenmiştir.");
        }elseif ($mail_json != $ayar['mail_ayarlari']) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "Mail ayarları güncellenmiştir.");
        }elseif ($sms_json != $ayar['sms_ayarlari']) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "SMS ayarları güncellenmiştir.");
        }elseif ($api_json != $ayar['api_ayarlari']) {
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "API ayarları güncellenmiştir.");
        }else{
            sistemLogEkle($db, 'UPDATE', 'Ayarlar', "Sistem Ayarları Güncellenmiştir.");
        }

        $site_url       = trim($_POST['site_url'] ?? '');
        $bakim_modu     = isset($_POST['bakim_modu']) ? 1 : 0;
        $google_maps    = trim($_POST['google_maps'] ?? '');

        $update = $db->prepare("UPDATE i_ayar SET  
            site_url         = :site_url,
            bakim_modu       = :bakim_modu,
            modul_ayarlari   = :modul_ayarlari,
            seo_ayarlari     = :seo_ayarlari,
            site_iletisim    = :site_iletisim,
            sosyal_medya     = :sosyal_medya,
            dil_ayarlari     = :dil_ayarlari,
            tarihce          = :tarihce,
            banka_bilgiler   = :banka_bilgiler,
            pos_ayarlari     = :pos_ayarlari,
            sepet_ayarlari   = :sepet_ayarlari,
            tema_ayarlari    = :tema_ayarlari,
            mail_ayarlari    = :mail_ayarlari,
            sms_ayarlari     = :sms_ayarlari,
            api_ayarlari     = :api_ayarlari,
            api_token        = :api_token,
            logo             = :logo,
            favicon          = :favicon,
            koyu_logo        = :koyu_logo,
            giris_resim      = :giris_resim,
            popup_resim      = :popup_resim,
            google_maps      = :google_maps
            WHERE id = 1");

        $sonuc = $update->execute([
            'site_url'       => $site_url,
            'bakim_modu'     => $bakim_modu,
            'modul_ayarlari' => $modul_json,
            'seo_ayarlari'   => $seo_json,
            'site_iletisim'  => $iletisim_json,
            'sosyal_medya'   => $sosyal_json,
            'dil_ayarlari'   => $dil_json,
            "tarihce"        => $tarihce_json, 
            'banka_bilgiler' => $banka_json,
            'pos_ayarlari'   => $pos_json,
            'sepet_ayarlari' => $sepet_json,
            'tema_ayarlari'  => $tema_ayar_json,
            'mail_ayarlari'  => $mail_json,
            'sms_ayarlari'   => $sms_json,
            'api_ayarlari'   => $api_json,
            'api_token'      => $api_token,
            'logo'           => $logo_yol,
            'favicon'        => $favicon_yol,
            'koyu_logo'      => $koyu_logo_yol,
            'giris_resim'    => $giris_resim_yol,
            'popup_resim'    => $popup_resim_yol,
            'google_maps'    => $google_maps
        ]);



        if($sonuc){
            alert("Başarılı", "Sistem ayarları başarıyla güncellendi.", "success", true);
        } else {
            alert("Hata", "Ayarlar kaydedilirken bir veritabanı hatası oluştu.", "error");
        }
    }


    if ($postType == "EditKilavuz") {

        $modullerDizi = $_POST['moduller'] ?? [];
        $kilavuzJson = json_encode($modullerDizi, JSON_UNESCAPED_UNICODE);

        $update = $db->prepare("UPDATE i_ayar SET kullanim_kilavuzu = ? WHERE id = 1");
        
        if ($update->execute([$kilavuzJson])) {
            sistemLogEkle($db, 'UPDATE', 'KILAVUZ', 'Kullanım kılavuzu ve SSS içerikleri güncellendi.');
            alert("Başarılı", "Kullanım kılavuzu başarıyla kaydedildi.", "success", true);
        } else {
            alert("Hata", "Kayıt sırasında bir hata oluştu.", "error");
        }
    }
}
?>