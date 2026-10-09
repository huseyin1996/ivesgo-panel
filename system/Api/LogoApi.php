<?php
class LogoApi {
    private $db;
    private $apiKey;
    private $apiSecret;
    private $apiUrl = "https://api.isbasi.com/api";

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    // Ayarlardan Logo API Bilgilerini Çekme
    private function configYukle() {
        $stmt = $this->db->query("SELECT api_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['api_ayarlari'])) {
                $decoded = json_decode($ayarData['api_ayarlari'], true);
                $logo = $decoded['logo'] ?? [];
                $this->apiKey    = $logo['api_key'] ?? '';
                $this->apiSecret = $logo['api_secret'] ?? '';
            }
        }
    }

    // Logo'da Cari (Müşteri) Kartı Oluşturma veya Güncelleme
    public function cariEkleVeyaGuncelle($musteriBilgileri) {
        if (empty($this->apiKey) || empty($this->apiSecret)) {
            return ['success' => false, 'message' => 'Logo API bilgileri eksik!'];
        }

        $url = "{$this->apiUrl}/v1/customers";

        $postData = [
            'name'        => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
            'email'       => $musteriBilgileri['eposta'] ?? '',
            'phone'       => $musteriBilgileri['telefon'] ?? '',
            'taxNumber'   => $musteriBilgileri['vergi_no'] ?? '',
            'taxOffice'   => $musteriBilgileri['vergi_dairesi'] ?? '',
            'address'     => $musteriBilgileri['adres'] ?? ''
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "ApiKey: {$this->apiKey}",
            "ApiSecret: {$this->apiSecret}"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['success']) && $result['success'] == true) {
            return ['success' => true, 'customer_id' => $result['data']['id'] ?? null];
        }

        return ['success' => false, 'message' => 'Logo Cari Hatası: ' . ($result['message'] ?? 'Bilinmeyen hata')];
    }

    // Logo'da Satış Faturası Kesme
    public function faturaKes($siparisVerileri, $musteriBilgileri, $urunler) {
        if (empty($this->apiKey) || empty($this->apiSecret)) {
            return ['success' => false, 'message' => 'Logo API bilgileri eksik!'];
        }

        $url = "{$this->apiUrl}/v1/invoices";

        $lines = [];
        foreach ($urunler as $urun) {
            $lines[] = [
                'itemCode'    => $urun['stok_kodu'] ?? 'SKU01',
                'itemName'    => $urun['adi'] ?? 'Ürün',
                'quantity'    => $urun['adet'] ?? 1,
                'unitPrice'   => $urun['fiyat'] ?? 0,
                'vatRate'     => $urun['kdv'] ?? 20
            ];
        }

        $postData = [
            'invoiceNumber' => $siparisVerileri['siparis_kodu'],
            'date'          => date('Y-m-d'),
            'customer'      => [
                'name'      => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
                'email'     => $musteriBilgileri['eposta'] ?? '',
                'phone'     => $musteriBilgileri['telefon'] ?? '',
                'address'   => $musteriBilgileri['adres'] ?? ''
            ],
            'lines'         => $lines
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "ApiKey: {$this->apiKey}",
            "ApiSecret: {$this->apiSecret}"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['success']) && $result['success'] == true) {
            return [
                'success'    => true, 
                'invoice_id' => $result['data']['id'] ?? null,
                'message'    => 'Logo faturası başarıyla oluşturuldu.'
            ];
        }

        return [
            'success' => false, 
            'message' => 'Logo Fatura Hatası: ' . ($result['message'] ?? 'Bilinmeyen hata')
        ];
    }
}