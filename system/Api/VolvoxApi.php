<?php
class VolvoxApi {
    private $db;
    private $servisUrl;
    private $kullanici Adi;
    private $sifre;
    private $firmaKodu;
    private $donemKodu;

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    // Ayarlardan Akınsoft Volvox Web Servis Bilgilerini Çekme
    private function configYukle() {
        $stmt = $this->db->query("SELECT api_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['api_ayarlari'])) {
                $decoded = json_decode($ayarData['api_ayarlari'], true);
                $volvox = $decoded['volvox'] ?? [];
                $this->servisUrl  = $volvox['servis_url'] ?? '';
                $this->kullaniciAdi = $volvox['kullanici_adi'] ?? '';
                $this->sifre      = $volvox['sifre'] ?? '';
                $this->firmaKodu  = $volvox['firma_kodu'] ?? '1';
                $this->donemKodu  = $volvox['donem_kodu'] ?? '1';
            }
        }
    }

    // Volvox'ta Cari (Müşteri) Kartı Açma / Güncelleme
    public function cariEkleVeyaGuncelle($musteriBilgileri) {
        if (empty($this->servisUrl)) {
            return ['success' => false, 'message' => 'Volvox Web Servis URL tanımlanmamış!'];
        }

        $postData = [
            'KullaniciAdi' => $this->kullaniciAdi,
            'Sifre'        => $this->sifre,
            'FirmaKodu'    => $this->firmaKodu,
            'DonemKodu'    => $this->donemKodu,
            'CariKodu'     => 'CR-' . ($musteriBilgileri['id'] ?? uniqid()),
            'CariAdi'      => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
            'Telefon'      => $musteriBilgileri['telefon'] ?? '',
            'Email'        => $musteriBilgileri['eposta'] ?? '',
            'VergiDairesi' => $musteriBilgileri['vergi_dairesi'] ?? '',
            'VergiNo'      => $musteriBilgileri['vergi_no'] ?? '',
            'Adres'        => $musteriBilgileri['adres'] ?? ''
        ];

        $ch = curl_init($this->servisUrl . "/CariEkle");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['Basarili']) && $result['Basarili'] == true) {
            return ['success' => true, 'message' => 'Volvox cari kartı başarıyla işlendi.'];
        }

        return ['success' => false, 'message' => 'Volvox Cari Hatası: ' . ($result['HataMesaji'] ?? 'Bilinmeyen hata')];
    }

    // Volvox'ta Fatura / Sipariş Faturası Oluşturma
    public function faturaKes($siparisVerileri, $musteriBilgileri, $urunler) {
        if (empty($this->servisUrl)) {
            return ['success' => false, 'message' => 'Volvox Web Servis URL tanımlanmamış!'];
        }

        $kalemler = [];
        foreach ($urunler as $urun) {
            $kalemler[] = [
                'StokKodu'    => $urun['stok_kodu'] ?? 'STK01',
                'StokAdi'     => $urun['adi'] ?? 'Ürün',
                'Miktar'      => $urun['adet'] ?? 1,
                'BirimFiyat'  => $urun['fiyat'] ?? 0,
                'KdvOrani'    => $urun['kdv'] ?? 20
            ];
        }

        $postData = [
            'KullaniciAdi' => $this->kullaniciAdi,
            'Sifre'        => $this->sifre,
            'FirmaKodu'    => $this->firmaKodu,
            'DonemKodu'    => $this->donemKodu,
            'EvrakNo'      => $siparisVerileri['siparis_kodu'],
            'Tarih'        => date('Y-m-d'),
            'CariUnvani'   => $musteriBilgileri['ad_soyad'] ?? 'Misafir Müşteri',
            'Kalemler'     => $kalemler
        ];

        $ch = curl_init($this->servisUrl . "/FaturaKes");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['Basarili']) && $result['Basarili'] == true) {
            return [
                'success'    => true, 
                'invoice_id' => $result['EvrakID'] ?? null,
                'message'    => 'Volvox faturası başarıyla oluşturuldu.'
            ];
        }

        return [
            'success' => false, 
            'message' => 'Volvox Fatura Hatası: ' . ($result['HataMesaji'] ?? 'Bilinmeyen hata')
        ];
    }
}