<?php

function kargoTakipUrlOlustur($firma, $takipNo) {
    if (empty($firma) || empty($takipNo)) return '';
    
    switch ($firma) {
        case 'Yurtiçi Kargo':
            return "https://selfservis.yurticikargo.com/reports/SSWDocumentDetail.aspx?DocId=" . $takipNo;
        case 'Sürat Kargo':
            return "http://suratkargo.com.tr/KargoTakip/?kargotakipno=" . $takipNo;
        case 'Aras Kargo':
            return "http://kargotakip.araskargo.com.tr/mainpage.aspx?code=" . $takipNo;
        case 'MNG Kargo':
            return "http://service.mngkargo.com.tr/iactive/popup/KargoTakip/link1.asp?k=" . $takipNo;
        case 'PTT Kargo':
            return "https://gonderitakip.ptt.gov.tr/Track/Verify?q=" . $takipNo;
        default:
            return '';
    }
}

if(isset($_POST)){
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_POST['csrf_token'] ?? '', $_SESSION['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'message' => 'CSRF koruması başarısız']);
            exit;
        }
    }

    if ($postType == "List") {
        $draw        = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $start       = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length      = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

        $columns = $_POST['columns'] ?? [];
        $searchQuery = " WHERE silindi = 0";
        $queryParams = [];

        if (!empty($searchValue)) {
            $searchQuery = " WHERE silindi = 0 AND (siparis_kodu LIKE ? OR musteri_bilgileri LIKE ?) ";
            $queryParams = ["%{$searchValue}%", "%{$searchValue}%"];
        }

        $orderQuery = " ORDER BY id DESC ";
        if (isset($_POST['order'])) {
            $columnIndex = intval($_POST['order'][0]['column']);
            $sortDir     = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $columnName  = $columns[$columnIndex]['data'] ?? 'id';
            $allowed     = ['siparis_kodu', 'genel_toplam', 'siparis_durumu', 'odeme_durumu', 'eklenme_tarihi', 'id'];
            if (in_array($columnName, $allowed)) {
                $orderQuery = " ORDER BY {$columnName} {$sortDir} ";
            }
        }

        $limitQuery = ($length != -1) ? " LIMIT {$start}, {$length} " : "";

        $totalQuery = $db->query("SELECT COUNT(id) as total FROM i_siparisler WHERE silindi = 0");
        $recordsTotal = $totalQuery->fetch()['total'] ?? 0;

        $filteredQuery = $db->prepare("SELECT COUNT(id) as total FROM i_siparisler" . $searchQuery);
        $filteredQuery->execute($queryParams);
        $recordsFiltered = $filteredQuery->fetch()['total'] ?? 0;

        $dataQuery = $db->prepare("SELECT * FROM i_siparisler" . $searchQuery . $orderQuery . $limitQuery);
        $dataQuery->execute($queryParams);
        $results = $dataQuery->fetchAll();

        $data = [];
        foreach ($results as $row) {
            $musteri_json = json_decode($row['musteri_bilgileri'], true);
            $musteri_isim = $musteri_json['ad_soyad'] ?? '-';
            
            $odeme_badge = ($row['odeme_durumu'] == 1) ? '<span class="badge bg-success">Ödendi</span>' : (($row['odeme_durumu'] == 2) ? '<span class="badge bg-danger">İptal/İade</span>' : '<span class="badge bg-warning text-dark">Bekliyor</span>');

            $durum_id = intval($row['siparis_durumu']);
            $durum_detay = siparis_durum($durum_id);
            $alert_to_badge = ['success' => 'bg-success', 'danger' => 'bg-danger', 'warning' => 'bg-warning text-dark', 'info' => 'bg-info text-dark', 'secondary' => 'bg-secondary'];
            $badge_class = $alert_to_badge[$durum_detay['alert']] ?? 'bg-secondary';
            $siparis_durum_badge = '<span class="badge ' . $badge_class . '"><i class="bi bi-' . $durum_detay['icon'] . ' me-1"></i> ' . $durum_detay['message'] . '</span>';

            $data[] = [
                'id'             => $row['id'], 
                'siparis_kodu'   => htmlspecialchars($row['siparis_kodu']),
                'musteri_adi'    => htmlspecialchars($musteri_isim),
                'genel_toplam'   => number_format($row['genel_toplam'], 2, ',', '.') . ' ' . $row['para_birimi'],
                'siparis_durumu' => $siparis_durum_badge,
                'odeme_durumu'   => $odeme_badge,
                'eklenme_tarihi' => tarihSaat($row['eklenme_tarihi']) 
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["draw" => $draw, "recordsTotal" => intval($recordsTotal), "recordsFiltered" => intval($recordsFiltered), "data" => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    function siparisVerileriniHazirla($db, $postVerileri) {
        $sonuc = [
            'ara_toplam' => 0, 'kdv_toplam' => 0, 'kampanya_indirim' => 0, 'genel_toplam' => 0,
            'musteri_arr' => [], 'fatura_arr' => [], 'teslimat_arr' => [], 'urunler_arr' => []
        ];

        $m_id = intval($postVerileri['musteri_id'] ?? 0);
        if($m_id > 0) {
            $m_sorgu = $db->prepare("SELECT * FROM i_musteriler WHERE id = ?");
            $m_sorgu->execute([$m_id]);
            $musteri = $m_sorgu->fetch(PDO::FETCH_ASSOC);

            if($musteri) {
                $sonuc['musteri_arr'] = [
                    'ad_soyad'      => $musteri['musteri_adi'],
                    'telefon'       => !empty($musteri['telefon']) ? $musteri['telefon'] : $musteri['gsm'],
                    'eposta'        => $musteri['eposta'],
                    'musteri_tipi'  => $musteri['musteri_tipi'],
                    'firma_unvani'  => $musteri['unvan'],
                    'vergi_dairesi' => $musteri['vergi_dairesi'],
                    'vergi_no'      => $musteri['vergi_no']
                ];
                $sonuc['fatura_arr'] = ['adres' => $musteri['fatura_adresi']];
                $sonuc['teslimat_arr'] = ['adres' => $musteri['sevk_adresi'], 'kisi' => $musteri['yetkili_kisi']];
            }
        } else {
            $sonuc['musteri_arr'] = [
                'ad_soyad'      => $postVerileri['ad_soyad'] ?? 'Misafir Müşteri',
                'telefon'       => $postVerileri['telefon'] ?? '',
                'eposta'        => $postVerileri['eposta'] ?? '',
                'musteri_tipi'  => $postVerileri['musteri_tipi'] ?? 'bireysel',
                'firma_unvani'  => $postVerileri['firma_unvani'] ?? '',
                'vergi_dairesi' => $postVerileri['vergi_dairesi'] ?? '',
                'vergi_no'      => $postVerileri['vergi_no'] ?? ''
            ];
            $sonuc['fatura_arr'] = ['adres' => $postVerileri['fatura_adres'] ?? ''];
            $sonuc['teslimat_arr'] = ['adres' => $postVerileri['teslimat_adres'] ?? ''];
        }

        if(isset($postVerileri['urun_id']) && is_array($postVerileri['urun_id'])) {
            foreach($postVerileri['urun_id'] as $key => $uid) {
                $uid = intval($uid);
                $miktar = intval($postVerileri['miktar'][$uid] ?? ($postVerileri['miktar'][$key] ?? 1));
                
                if($miktar > 0 && $uid > 0) { 
                    $urun_varmi = $db->prepare("SELECT * FROM i_urunler WHERE urun_id = ?");
                    $urun_varmi->execute([$uid]);
                    
                    if($urun_varmi->rowCount()) {
                        $urun_cek = $urun_varmi->fetch(PDO::FETCH_ASSOC);
                        
                        $resim_sorgu = $db->prepare("SELECT resim FROM i_urun_resimler WHERE urun_id = ? LIMIT 1");
                        $resim_sorgu->execute([$urun_cek["urun_id"]]);
                        $resim_cek = $resim_sorgu->fetch();
                        
                        $resim_yolu = "assets/images/urunler/" . ($resim_cek['resim'] ?? '');
                        $resim = (!empty($resim_cek['resim']) && file_exists($resim_yolu)) ? $resim_yolu : 'assets/images/resim-yok.png';
                        
                        $urun_url = "urun/" . $urun_cek["urun_url"] . "/";
                        $fiyat = ($urun_cek['urun_indirim'] > 0) ? floatval($urun_cek['urun_indirim']) : floatval($urun_cek['urun_fiyat']);
                        $kdv_orani = intval($urun_cek['urun_kdv']);
                        
                        $kdv_durumu = isset($postVerileri['kdv_durum'][$uid]) ? intval($postVerileri['kdv_durum'][$uid]) : (isset($postVerileri['kdv_durum'][$key]) ? intval($postVerileri['kdv_durum'][$key]) : 2);

                        if ($kdv_durumu == 1) { 
                            $kdv_haric_tutar = $fiyat * $miktar;
                            $kdv_tutari = ($kdv_haric_tutar * $kdv_orani) / 100;
                            $satir_toplam_kdvli = $kdv_haric_tutar + $kdv_tutari;
                        } else { 
                            $satir_toplam_kdvli = $fiyat * $miktar;
                            $kdv_haric_tutar = $satir_toplam_kdvli / (1 + ($kdv_orani / 100));
                            $kdv_tutari = $satir_toplam_kdvli - $kdv_haric_tutar;
                        }

                        $sonuc['ara_toplam'] += $kdv_haric_tutar;
                        $sonuc['kdv_toplam'] += $kdv_tutari;

                        $sonuc['urunler_arr'][] = [
                            "id"            => $urun_cek['urun_id'],
                            "adi"           => $urun_cek["urun_adi"],
                            "stok_kodu"     => $urun_cek["stok_kodu"],
                            "adet"          => $miktar,
                            "kategori"      => $urun_cek['urun_kategori'],
                            "resim"         => $resim,
                            "url"           => $urun_url,
                            "fiyat"         => $fiyat,
                            "kdv"           => $kdv_orani,
                            "kdv_durumu"    => ($kdv_durumu == 1) ? 'Hariç' : 'Dahil',
                            "satir_toplam"  => $satir_toplam_kdvli
                        ];
                    }
                }
            }
        }

        $urunler_toplam_kdvli = $sonuc['ara_toplam'] + $sonuc['kdv_toplam'];
        $kampanya_id = intval($postVerileri['kampanya_id'] ?? 0);
        $kargo = floatval($postVerileri['kargo_ucreti'] ?? 0);

        if($kampanya_id > 0) {
            $k_sorgu = $db->prepare("SELECT * FROM i_kampanyalar WHERE id = ? AND durum = 1");
            $k_sorgu->execute([$kampanya_id]);
            $kampanya = $k_sorgu->fetch(PDO::FETCH_ASSOC);

            if($kampanya) {
                if($urunler_toplam_kdvli >= floatval($kampanya['min_sepet_tutar'])) {
                    if($kampanya['kampanya_turu'] == 'yuzde_indirim') {
                        $sonuc['kampanya_indirim'] = ($urunler_toplam_kdvli * floatval($kampanya['indirim_orani'])) / 100;
                    } elseif($kampanya['kampanya_turu'] == 'tutar_indirim') {
                        $sonuc['kampanya_indirim'] = floatval($kampanya['indirim_orani']);
                    } elseif($kampanya['kampanya_turu'] == 'ucretsiz_kargo') {
                        $kargo = 0.00;
                    }
                }
            }
        }

        $manuel_indirim = floatval($postVerileri['indirim_toplam'] ?? 0);
        $toplam_indirim = $sonuc['kampanya_indirim'] + $manuel_indirim;

        $sonuc['genel_toplam'] = $urunler_toplam_kdvli + $kargo - $toplam_indirim;
        if($sonuc['genel_toplam'] < 0) $sonuc['genel_toplam'] = 0.00;

        return $sonuc;
    }

    if ($postType == "Add") {
        $hesap = siparisVerileriniHazirla($db, $_POST);
        
        if(empty($hesap['urunler_arr'])) {
            alert("Uyarı", "Lütfen sepete en az bir ürün ekleyiniz.", "warning");
            exit;
        }

        $yeni_siparis_kodu = "SIP-" . date("Ymd") . "-" . strtoupper(substr(md5(uniqid()), 0, 5));

        // Ödeme Yöntemi Belirleme ve Sanal POS / Kredi Kartı Kontrolü
        $secilen_odeme_yontemi = !empty($odeme_yontemi) ? $odeme_yontemi : 'Kredi Kartı';
        
        // Eğer kredi kartı ile alınıyorsa başlangıçta ödeme durumu 0 (Bekliyor) yapılır, POS yanıtına göre güncellenir.
        $baslangic_odeme_durumu = (strpos(strtolower($secilen_odeme_yontemi), 'kredi') !== false) ? 0 : intval($odeme_durumu ?? 0);

        $array = [
            "siparis_kodu"      => $yeni_siparis_kodu,
            "musteri_id"        => intval($musteri_id ?? 0),
            "siparis_personel"  => $giris_cek['uye_id'],
            "musteri_bilgileri" => json_encode($hesap['musteri_arr'], JSON_UNESCAPED_UNICODE),
            "urunler"           => json_encode($hesap['urunler_arr'], JSON_UNESCAPED_UNICODE),
            "fatura_adresi"     => json_encode($hesap['fatura_arr'], JSON_UNESCAPED_UNICODE),
            "teslimat_adresi"   => json_encode($hesap['teslimat_arr'], JSON_UNESCAPED_UNICODE),
            "ara_toplam"        => $hesap['ara_toplam'],
            "kdv_toplam"        => $hesap['kdv_toplam'],
            "indirim_toplam"    => floatval($indirim_toplam ?? 0) + $hesap['kampanya_indirim'],
            "kargo_ucreti"      => floatval($kargo_ucreti ?? 0),
            "genel_toplam"      => $hesap['genel_toplam'],
            "para_birimi"       => 'TRY',
            "odeme_yontemi"     => $secilen_odeme_yontemi,
            "odeme_durumu"      => $baslangic_odeme_durumu,
            "siparis_durumu"    => !empty($siparis_durumu) ? $siparis_durumu : '8',
            "admin_notu"        => !empty($admin_notu) ? $admin_notu : '',
            "ip_adresi"         => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        $add = $db->prepare("INSERT INTO i_siparisler SET
            siparis_kodu      = :siparis_kodu,
            musteri_id        = :musteri_id,
            siparis_personel  = :siparis_personel,
            musteri_bilgileri = :musteri_bilgileri,
            urunler           = :urunler,
            fatura_adresi     = :fatura_adresi,
            teslimat_adresi   = :teslimat_adresi,
            ara_toplam        = :ara_toplam,
            kdv_toplam        = :kdv_toplam,
            indirim_toplam    = :indirim_toplam,
            kargo_ucreti      = :kargo_ucreti,
            genel_toplam      = :genel_toplam,
            para_birimi       = :para_birimi,
            odeme_yontemi     = :odeme_yontemi,
            odeme_durumu      = :odeme_durumu,
            siparis_durumu    = :siparis_durumu,
            admin_notu        = :admin_notu,
            ip_adresi         = :ip_adresi");
            
        if($add->execute($array)){
            $OlusturulanSiparisID = $db->lastInsertId();
            $_SESSION["siparis_id"] = $yeni_siparis_kodu;

            if (strpos(strtolower($secilen_odeme_yontemi), 'kredi') !== false || strpos(strtolower($secilen_odeme_yontemi), 'pos') !== false) {
                alert("Başarılı", "Sipariş oluşturuldu, ödeme sayfasına yönlendiriliyorsunuz...", "success", true, 'odeme');
                exit;
            }else{
                sistemLogEkle($db, 'ADD', 'Siparişler', "Yeni Sipariş Alındı. Sipariş Kodu: {$siparis_kodu} ");
                
                bildirimEkle($db, "Yeni Sipariş Oluşturuldu", "Sipariş Kodu: {$siparis_kodu} olan yeni bir sipariş eklendi.", null, "success", "siparis-goruntule/{$siparis_id}");
                
                alert("Başarılı", "Sipariş başarıyla oluşturulmuştur.", "success", true);
            }

        }else{
            alert("Hata", "Sipariş kaydedilemedi.", "error");
        }
    }

    if ($postType == "Edit") {
        if(!empty($value)){
            $sor = $db->prepare("SELECT * FROM i_siparisler WHERE id = ?");
            $sor->execute([$value]);
            $siparis = $sor->fetch(PDO::FETCH_ASSOC);

            if(!$siparis) {
                alert("Hata", "Sipariş bulunamadı.", "error");
                exit;
            }

            $musteri_id = isset($musteri_id) ? intval($musteri_id) : 0;
            $hesap = siparisVerileriniHazirla($db, $_POST);

            $kargo_ucreti = isset($kargo_ucreti) ? floatval($kargo_ucreti) : floatval($siparis['kargo_ucreti']);
            $indirim_toplam = isset($indirim_toplam) ? floatval($indirim_toplam) : floatval($siparis['indirim_toplam']);
            
            $kargo_takip_url = '';
            if (isset($siparis_durumu) && $siparis_durumu == 2 && !empty($kargo_firmasi) && !empty($kargo_takip_no)) {
                $kargo_takip_url = kargoTakipUrlOlustur($kargo_firmasi, $kargo_takip_no);
            }
            
            if ($musteri_id > 0) {
                $musteri_update = $db->prepare("UPDATE i_musteriler SET
                    musteri_tipi    = :musteri_tipi,
                    musteri_adi     = :musteri_adi,
                    unvan           = :unvan,
                    yetkili_kisi    = :yetkili_kisi,
                    eposta          = :eposta,
                    telefon         = :telefon,
                    gsm             = :gsm,
                    fatura_adresi   = :fatura_adresi,
                    sevk_adresi     = :sevk_adresi,
                    vergi_dairesi   = :vergi_dairesi,
                    vergi_no        = :vergi_no
                    WHERE id        = :id");
                
                $musteri_update->execute([
                    "musteri_tipi"  => !empty($musteri_tipi) ? $musteri_tipi : "bireysel",
                    "musteri_adi"   => $ad_soyad ?? '',
                    "unvan"         => $firma_unvani ?? '',
                    "yetkili_kisi"  => $yetkili_kisi ?? '',
                    "eposta"        => $eposta ?? '',
                    "telefon"       => $telefon ?? '',
                    "gsm"           => $gsm ?? '',
                    "fatura_adresi" => $fatura_adres ?? '',
                    "sevk_adresi"   => $teslimat_adres ?? '',
                    "vergi_dairesi" => $vergi_dairesi ?? '',
                    "vergi_no"      => $vergi_no ?? '',
                    "id"            => $musteri_id
                ]);
                sistemLogEkle($db, 'UPDATE', 'Musteriler', "Müşteri bilgileri güncellendi Müşteri ID: {$musteri_id} ");
            }

            $update = $db->prepare("UPDATE i_siparisler SET
                musteri_id          = :musteri_id,
                siparis_personel    = :siparis_personel,
                musteri_bilgileri   = :musteri_bilgileri,
                urunler             = :urunler,
                fatura_adresi       = :fatura_adresi,
                teslimat_adresi     = :teslimat_adresi,
                ara_toplam          = :ara_toplam,
                kdv_toplam          = :kdv_toplam,
                indirim_toplam      = :indirim_toplam,
                kargo_ucreti        = :kargo_ucreti,
                genel_toplam        = :genel_toplam,
                siparis_durumu      = :siparis_durumu,
                odeme_durumu        = :odeme_durumu,
                kargo_firmasi       = :kargo_firmasi,
                kargo_takip_no      = :kargo_takip_no,
                kargo_takip_url     = :kargo_takip_url,
                admin_notu          = :admin_notu
                WHERE id            = :id");

            $kontrol = $update->execute([
                "musteri_id"        => $musteri_id,
                "siparis_personel"  => $giris_cek['uye_id'],
                "musteri_bilgileri" => json_encode($hesap['musteri_arr'], JSON_UNESCAPED_UNICODE),
                "urunler"           => json_encode($hesap['urunler_arr'], JSON_UNESCAPED_UNICODE),
                "fatura_adresi"     => json_encode($hesap['fatura_arr'], JSON_UNESCAPED_UNICODE),
                "teslimat_adresi"   => json_encode($hesap['teslimat_arr'], JSON_UNESCAPED_UNICODE),
                "ara_toplam"        => $hesap['ara_toplam'],
                "kdv_toplam"        => $hesap['kdv_toplam'],
                "indirim_toplam"    => $indirim_toplam + $hesap['kampanya_indirim'],
                "kargo_ucreti"      => $kargo_ucreti,
                "genel_toplam"      => $hesap['genel_toplam'],
                "siparis_durumu"    => !empty($siparis_durumu) ? $siparis_durumu : $siparis['siparis_durumu'],
                "odeme_durumu"      => isset($odeme_durumu) ? intval($odeme_durumu) : $siparis['odeme_durumu'],
                "kargo_firmasi"     => !empty($kargo_firmasi) ? $kargo_firmasi : '',
                "kargo_takip_no"    => !empty($kargo_takip_no) ? $kargo_takip_no : '',
                "kargo_takip_url"   => !empty($kargo_takip_url) ? $kargo_takip_url : '',
                "admin_notu"        => !empty($admin_notu) ? $admin_notu : '',
                "id"                => $value
            ]);

            if($kontrol){
                $log = sistemLogEkle($db, 'UPDATE', 'Siparişler', "Sipariş Kodu: {$siparis['siparis_kodu']} için sipariş güncellendi.");
                alert("Başarılı", "Sipariş ve müşteri bilgileri güncellendi.", "success", true);

            }else{
                alert("Hata", "Güncelleme sırasında bir sorun oluştu.", "error");
            }
        }
    }

    if ($postType == "Sil") {
        if(!empty($id)){
            $siparisSor = $db->prepare("SELECT siparis_kodu FROM i_siparisler WHERE id = ?");
            $siparisSor->execute([$id]);
            $siparisBilgi = $siparisSor->fetch(PDO::FETCH_ASSOC);
            $siparisKodu = $siparisBilgi['siparis_kodu'] ?? 'Bilinmeyen';

            $del = $db->prepare("UPDATE i_siparisler SET silindi = 1 WHERE id = ?");
            $del->execute([$id]);

            if($del->rowCount()){
                sistemLogEkle($db, 'DELETE', 'Siparişler', "Sipariş Kodu: {$siparisKodu} olan sipariş silindi.");
                
                alert("Başarılı", "Sipariş silinmiştir.", "success", true);
            }
        }
    }
}
?>