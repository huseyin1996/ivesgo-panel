<?php


if (isset($_POST['postType']) || isset($_GET['postType'])) {
    header('Content-Type: application/json; charset=utf-8');
    require_once 'system/ayar.php'; // Yolunuza göre ayarlayın

    $postType = $_POST['postType'] ?? $_GET['postType'];

    if ($postType === 'get_dashboard_data') {
        // Dış servis veya veritabanı işlemleriniz
        $postVerileri = [
            'api_token' => $ayar['api_token'] ?? '',
            'token' => 'IVS++159',
            'site_domain' => $_SERVER['HTTP_HOST'] ?? ''
        ];

        $postData = http_build_query($postVerileri, '', '&');
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://www.ivesgo.com/panelApi.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 20
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $veriler = json_decode($response, true);
        
        $chartLabels = [];
        $chartData = [];
        $hizmetListesi = [];
        
        $toplamHizmet = 0;
        $suresiGecenler = 0;
        $toplamKalanGun = 0;
        $toplamTutar = 0;

        if (isset($veriler['durum']) && $veriler['durum'] == "basarili" && !empty($veriler['websiteler'])) {
            $simdikiZaman = new DateTime();
            $toplamHizmet = count($veriler['websiteler']);

            foreach ($veriler['websiteler'] as $row) {
                if (isset($row['paket_detay'])) {
                    $paketAdi = $row['paket_detay']['paket_adi'];
                    $baslangicTarihi = new DateTime($row['yenilemetarihi']);
                    $bitisTarihi = new DateTime($row['hizmetuzat']);
                    $fiyat = (float) $row['paket_detay']['paket_fiyati'];

                    $toplamTutar += $fiyat;

                    $toplamGunInterval = $baslangicTarihi->diff($bitisTarihi);
                    $toplamGun = $toplamGunInterval->days > 0 ? $toplamGunInterval->days : 1;

                    $kalanGunInterval = $simdikiZaman->diff($bitisTarihi);
                    $kalanGun = $kalanGunInterval->invert ? 0 : $kalanGunInterval->days;

                    $suresiGectiMi = $simdikiZaman > $bitisTarihi;
                    if ($suresiGectiMi) $suresiGecenler++;

                    $toplamKalanGun += $kalanGun;
                    $kalanYuzde = min(100, max(0, round(($kalanGun / $toplamGun) * 100)));

                    $chartLabels[] = $paketAdi;
                    $chartData[] = (int) $kalanGun;

                    $hizmetListesi[] = [
                        'paket_adi' => $paketAdi,
                        'website' => $row['website'],
                        'hizmet_uzat' => $row['hizmetuzat'],
                        'kalan_gun' => $kalanGun,
                        'kalan_yuzde' => $kalanYuzde,
                        'suresi_gecti' => $suresiGectiMi
                    ];
                }
            }
        }

        $ortalamaKalanGun = $toplamHizmet > 0 ? round($toplamKalanGun / $toplamHizmet) : 0;

        echo json_encode([
            'durum' => 'basarili',
            'istatistikler' => [
                'toplam_hizmet' => $toplamHizmet,
                'suresi_gecenler' => $suresiGecenler,
                'ortalama_kalan_gun' => $ortalamaKalanGun,
                'toplam_tutar' => number_format($toplamTutar, 2, ',', '.') . ' ₺'
            ],
            'labels' => $chartLabels,
            'data' => $chartData,
            'hizmetler' => $hizmetListesi
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($postType === 'get_analytics_data') {
        
        $tema_json_decode = json_decode($ayar["tema_ayarlari"] ?? '{}', true);
        $tema_cek = $tema_json_decode["tema_ayar"] ?? [];

        $propertyId = $tema_cek["ga_property_id"];
        $keyFile = 'system/google-key.json';     
        if (!empty($propertyId)) {
            try {
                if (!file_exists($keyFile)) {
                    throw new Exception("Google key JSON dosyası bulunamadı.");
                }

                $keyData = json_decode(file_get_contents($keyFile), true);
                $clientEmail = $keyData['client_email'];
                $privateKey = $keyData['private_key'];

                $now = time();
                $payload = [
                    'iss' => $clientEmail,
                    'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
                    'aud' => 'https://oauth2.googleapis.com/token',
                    'exp' => $now + 3600,
                    'iat' => $now
                ];

                $header = ['alg' => 'RS256', 'typ' => 'JWT'];
                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($header)));
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

                $signatureInput = $base64UrlHeader . "." . $base64UrlPayload;
                $signature = '';
                openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                $jwt = $signatureInput . "." . $base64UrlSignature;

                $ch = curl_init('https://oauth2.googleapis.com/token');
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query([
                        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                        'assertion' => $jwt
                    ]),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_TIMEOUT => 20
                ]);
                $tokenResponse = curl_exec($ch);
                curl_close($ch);

                $tokenData = json_decode($tokenResponse, true);
                if (!isset($tokenData['access_token'])) {
                    throw new Exception("Google Access Token alınamadı.");
                }
                $accessToken = $tokenData['access_token'];

                // GA4 API üzerinden ihtiyaç duyulan tüm metrikleri çekiyoruz
                $apiUrl = "https://analyticsdata.googleapis.com/v1beta/properties/{$propertyId}:runReport";
                $reportData = [
                    'dateRanges' => [['startDate' => '7daysAgo', 'endDate' => 'today']],
                    'metrics' => [
                        ['name' => 'activeUsers'],              // Aktif Kullanıcı
                        ['name' => 'sessions'],                 // Oturumlar
                        ['name' => 'screenPageViews'],          // Sayfa Görüntülenmeleri (Lead analitiği karşılığı)
                        ['name' => 'bounceRate'],               // Hemen Çıkma Oranı
                        ['name' => 'averageSessionDuration']    // Ortalama Oturum Süresi (Saniye)
                    ]
                ];

                $ch = curl_init($apiUrl);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($reportData),
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer ' . $accessToken,
                        'Content-Type: application/json'
                    ],
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_TIMEOUT => 20
                ]);
                $apiResponse = curl_exec($ch);
                curl_close($ch);

                $reportResult = json_decode($apiResponse, true);

                $activeUsers = 0;
                $sessions = 0;
                $pageViews = 0;
                $bounceRate = 0;
                $avgDurationSeconds = 0;

                if (isset($reportResult['rows'][0]['metricValues'])) {
                    $rows = $reportResult['rows'][0]['metricValues'];
                    $activeUsers = $rows[0]['value'] ?? 0;
                    $sessions = $rows[1]['value'] ?? 0;
                    $pageViews = $rows[2]['value'] ?? 0;
                    $bounceRate = round(($rows[3]['value'] ?? 0) * 100, 1);
                    $avgDurationSeconds = round($rows[4]['value'] ?? 0);
                }

                // Saniyeyi Dakika ve Saniye formatına çevirme (Örn: 252 -> 4m 12s)
                $dakika = floor($avgDurationSeconds / 60);
                $saniye = $avgDurationSeconds % 60;
                $formattedDuration = "{$dakika}m {$saniye}s";

                // Sayıları okunaklı formata dönüştürme
                $formattedUsers = number_format($activeUsers, 0, ',', '.');
                $formattedSessions = ($sessions >= 1000) ? round($sessions / 1000, 2) . 'k' : $sessions;
                $formattedPageViews = number_format($pageViews, 0, ',', '.');

                echo json_encode([
                    'durum' => 'basarili',
                    'analytics' => [
                        'visitors_online' => $formattedUsers,
                        'bounce_rate' => $bounceRate . '%',
                        'avg_duration' => $formattedDuration,
                        'lead_analytics' => $formattedPageViews,
                        'sessions' => $formattedSessions,
                        // Dinamik veya hesaplanan değişim etiketleri
                        'visitor_change' => '+ Aktif',
                        'bounce_change' => $bounceRate > 50 ? 'Yüksek' : 'Normal',
                        'duration_change' => 'Canlı',
                        'lead_change' => 'Güncel',
                        'session_change' => 'Toplam'
                    ]
                ], JSON_UNESCAPED_UNICODE);

            } catch (\Exception $e) {
                echo json_encode([
                    'durum' => 'hata', 
                    'mesaj' => $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            }
            exit;
        }
    }
}
?>