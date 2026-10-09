<?php
class WhatsAppApi {
    private $db;
    private $accessToken;
    private $phoneNumberId;
    private $apiVersion = "v18.0";

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    // Ayarlardan WhatsApp API Bilgilerini Çekme
    private function configYukle() {
        $stmt = $this->db->query("SELECT api_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['api_ayarlari'])) {
                $decoded = json_decode($ayarData['api_ayarlari'], true);
                $wa = $decoded['whatsapp'] ?? [];
                $this->accessToken   = $wa['access_token'] ?? '';
                $this->phoneNumberId = $wa['phone_number_id'] ?? '';
            }
        }
    }

    // Müşteriye Şablon Mesajı Gönderme
    public function siparisMesajiGonder($telefon, $musteriAdi, $siparisKodu, $durumMesaji) {
        if (empty($this->accessToken) || empty($this->phoneNumberId)) {
            return ['success' => false, 'message' => 'WhatsApp API bilgileri eksik!'];
        }

        // Telefon numarasını uluslararası formata dönüştür (Örn: 905554443322)
        $telefon = preg_replace('/[^0-9]/', '', $telefon);
        if (substr($telefon, 0, 1) == '0') {
            $telefon = '9' . $telefon;
        }

        $url = "https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}/messages";

        $postData = [
            'messaging_product' => 'whatsapp',
            'to'                => $telefon,
            'type'              => 'template',
            'template'          => [
                'name'     => 'siparis_durum_bilgilendirme',
                'language' => ['code' => 'tr'],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $musteriAdi],
                            ['type' => 'text', 'text' => $siparisKodu],
                            ['type' => 'text', 'text' => $durumMesaji]
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->accessToken}",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['messages'][0]['id'])) {
            return ['success' => true, 'message' => 'WhatsApp mesajı başarıyla gönderildi.'];
        }

        return ['success' => false, 'message' => 'WhatsApp Gönderim Hatası: ' . ($result['error']['message'] ?? 'Bilinmeyen hata')];
    }
}