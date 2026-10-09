<?php
class BizimHesapApi {
    private $db;
    private $apiKey;
    private $apiUrl = "https://api.bizimhesap.com/api"; // Bizim Hesap API endpoint

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    // Ayarlardan Bizim Hesap API Anahtarını Çekme
    private function configYukle() {
        $stmt = $this->db->query("SELECT api_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['api_ayarlari'])) {
                $decoded = json_decode($ayarData['api_ayarlari'], true);
                $bizimhesap = $decoded['bizimhesap'] ?? [];
                $this->apiKey = $bizimhesap['api_key'] ?? '';
            }
        }
    }

    // Bizim Hesap'ta Cari (Müşteri) Ekleme / Güncelleme
    public function cariEkleVeyaGuncelle($musteriBilgileri) {
        if (empty($this->apiKey)) {
            return ['success' => false, 'message' => 'Bizim Hesap API Anahtarı tanımlanmamış!'];
        }

        $url = "https://www.bizimhesap.com/api/b2b/customerave"; // Örnek cari endpoint

        $postData = [
            'ApiKey'     => $this->apiKey,
            'Code'       => 'CARI-' . ( $musteriBilgileri['id'] ?? uniqid() ),
            'Name'       => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
            'Phone'      => $musteriBilgileri['telefon'] ?? '',
            'Email'      => $musteriBilgileri['eposta'] ?? '',
            'TaxNumber'  => $musteriBilgileri['vergi_no'] ?? '',
            'TaxOffice'  => $musteriBilgileri['vergi_dairesi'] ?? '',
            'Address'    => $musteriBilgileri['adres'] ?? ''
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['IsSuccess']) && $result['IsSuccess'] == true) {
            return ['success' => true, 'message' => 'Cari başarıyla eklendi.'];
        }

        return ['success' => false, 'message' => 'Bizim Hesap Cari Hatası: ' . ($result['Message'] ?? 'Bilinmeyen hata')];
    }

    // Bizim Hesap'ta Satış Faturası Kesme
    public function faturaKes($siparisVerileri, $musteriBilgileri, $urunler) {
        if (empty($this->apiKey)) {
            return ['success' => false, 'message' => 'Bizim Hesap API Anahtarı tanımlanmamış!'];
        }

        $url = "https://www.bizimhesap.com/api/b2b/addinvoice";

        $items = [];
        foreach ($urunler as $urun) {
            $items[] = [
                'BarCode'     => $urun['stok_kodu'] ?? '',
                'ProductName' => $urun['adi'] ?? 'Ürün',
                'Quantity'    => $urun['adet'] ?? 1,
                'Price'       => $urun['fiyat'] ?? 0,
                'VatRate'     => $urun['kdv'] ?? 20
            ];
        }

        $postData = [
            'ApiKey'      => $this->apiKey,
            'BillCode'    => $siparisVerileri['siparis_kodu'],
            'IssueDate'   => date('Y-m-d'),
            'Customer'    => [
                'Name'      => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
                'Email'     => $musteriBilgileri['eposta'] ?? '',
                'Phone'     => $musteriBilgileri['telefon'] ?? '',
                'Address'   => $musteriBilgileri['adres'] ?? ''
            ],
            'Items'       => $items
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['IsSuccess']) && $result['IsSuccess'] == true) {
            return ['success' => true, 'message' => 'Bizim Hesap faturası başarıyla oluşturuldu.'];
        }

        return ['success' => false, 'message' => 'Bizim Hesap Fatura Hatası: ' . ($result['Message'] ?? 'Bilinmeyen hata')];
    }
}