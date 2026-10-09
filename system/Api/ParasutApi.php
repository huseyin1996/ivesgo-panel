<?php
class ParasutApi {
    private $db;
    private $clientId;
    private $clientSecret;
    private $username;
    private $password;
    private $companyId;
    private $apiUrl = "https://api.parasut.com/v4";
    private $tokenUrl = "https://api.parasut.com/oauth/token";

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    private function configYukle() {
        $stmt = $this->db->query("SELECT api_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['api_ayarlari'])) {
                $decoded = json_decode($ayarData['api_ayarlari'], true);
                $parasut = $decoded['parasut'] ?? [];
                $this->clientId     = $parasut['client_id'] ?? '';
                $this->clientSecret = $parasut['client_secret'] ?? '';
                $this->username     = $parasut['username'] ?? '';
                $this->password     = $parasut['password'] ?? '';
                $this->companyId    = $parasut['company_id'] ?? '';
            }
        }
    }

    // OAuth2 Access Token Alma
    private function getToken() {
        $postData = [
            'grant_type'    => 'password',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username'      => $this->username,
            'password'      => $this->password,
            'redirect_uri'  => 'urn:ietf:wg:oauth:2.0:oob'
        ];

        $ch = curl_init($this->tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }

    public function cariOlusturVeyaBul($musteriBilgileri) {
        $token = $this->getToken();
        if (!$token) return ['success' => false, 'message' => 'Paraşüt API Token alınamadı.'];

        $url = "{$this->apiUrl}/{$this->companyId}/contacts";

        $postData = [
            'data' => [
                'type' => 'contacts',
                'attributes' => [
                    'name'          => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
                    'email'         => $musteriBilgileri['eposta'] ?? '',
                    'phone'         => $musteriBilgileri['telefon'] ?? '',
                    'account_type'  => 'customer',
                    'tax_number'    => $musteriBilgileri['vergi_no'] ?? '',
                    'tax_office'    => $musteriBilgileri['vergi_dairesi'] ?? '',
                    'address'       => $musteriBilgileri['adres'] ?? ''
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['data']['id'])) {
            return ['success' => true, 'contact_id' => $result['data']['id']];
        }

        return ['success' => false, 'message' => 'Cari oluşturulamadı: ' . ($result['errors'][0]['title'] ?? 'Bilinmeyen hata')];
    }

    public function faturaKes($siparisVerileri, $musteriBilgileri, $urunler) {
        $token = $this->getToken();
        if (!$token) return ['success' => false, 'message' => 'Paraşüt API Token alınamadı.'];

        $cariSonuc = $this->cariOlusturVeyaBul($musteriBilgileri);
        if (!$cariSonuc['success']) {
            return $cariSonuc;
        }
        $contactId = $cariSonuc['contact_id'];

        $url = "{$this->apiUrl}/{$this->companyId}/sales_invoices";

        $details = [];
        foreach ($urunler as $urun) {
            $details[] = [
                'quantity'    => $urun['adet'] ?? 1,
                'unit_price'  => $urun['fiyat'] ?? 0,
                'vat_rate'    => $urun['kdv'] ?? 20,
                'description' => $urun['adi'] ?? 'Ürün'
            ];
        }

        $postData = [
            'data' => [
                'type' => 'sales_invoices',
                'attributes' => [
                    'item_type'     => 'invoice',
                    'invoice_no'    => $siparisVerileri['siparis_kodu'],
                    'date'          => date('Y-m-d'),
                    'due_date'      => date('Y-m-d'),
                    'invoice_type'  => 'satis',
                    'description'   => "Sipariş Kodu: " . $siparisVerileri['siparis_kodu']
                ],
                'relationships' => [
                    'contact' => [
                        'data' => ['type' => 'contacts', 'id' => (string)$contactId]
                    ],
                    'details' => [
                        'data' => $details
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['data']['id'])) {
            return [
                'success'    => true, 
                'invoice_id' => $result['data']['id'],
                'message'    => 'Fatura başarıyla Paraşüt üzerinde oluşturuldu.'
            ];
        }

        return [
            'success' => false, 
            'message' => 'Fatura kesilemedi: ' . ($result['errors'][0]['title'] ?? 'Bilinmeyen hata')
        ];
    }
}