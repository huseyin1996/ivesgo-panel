<?php
class SanalPos {
    private $db;
    private $posConfig = [];
    private $aktifPosAdi = '';

    public function __construct($db) {
        $this->db = $db;
        $this->configYukle();
    }

    private function configYukle() {
        $stmt = $this->db->query("SELECT pos_ayarlari FROM i_ayar LIMIT 1");
        if ($stmt && $stmt->rowCount() > 0) {
            $ayarData = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($ayarData['pos_ayarlari'])) {
                $decoded = json_decode($ayarData['pos_ayarlari'], true);
                if (is_array($decoded)) {
                    $this->posConfig = $decoded;
                    $this->aktifPosAdi = $decoded['aktif_pos'] ?? '';
                }
            }
        }
    }

    public function odemeBaslat($siparisBilgileri, $teslimatBilgileri, $sepetVerileri, $ekVeriler = []) {
        if (empty($this->aktifPosAdi) || !isset($this->posConfig[$this->aktifPosAdi])) {
            return ['success' => false, 'message' => 'Aktif bir Sanal POS yapılandırılmamış!'];
        }

        $aktifAyarlar = $this->posConfig[$this->aktifPosAdi];

        switch (strtolower($this->aktifPosAdi)) {
            case 'paytr':
                return $this->paytrEntegrasyon($siparisBilgileri, $teslimatBilgileri, $sepetVerileri, $aktifAyarlar);
            case 'iyzico':
                return $this->iyzicoEntegrasyon($siparisBilgileri, $teslimatBilgileri, $sepetVerileri, $ekVeriler, $aktifAyarlar);
            case 'moka':
                return $this->mokaEntegrasyon($siparisBilgileri, $ekVeriler, $aktifAyarlar);
            default:
                return ['success' => false, 'message' => 'Geçersiz POS sağlayıcısı.'];
        }
    }

    private function paytrEntegrasyon($siparis, $teslimat, $sepet, $ayar) {

        $merchant_id   = $ayar['merchant_id'] ?? '';
        $merchant_key  = $ayar['merchant_key'] ?? '';
        $merchant_salt = $ayar['merchant_salt'] ?? '';

        $email          = $teslimat["email"] ?? '';
        $fiyat          = $siparis['toplam_tutar'] ?? ($siparis['fiyat'] ?? 0);;
        $payment_amount = intval($fiyat * 100);

        $merchant_oid   = $siparis['takip_no'];
        $user_name      = $teslimat["ad_soyad"] ?? '';
        $user_address   = $teslimat["adres"] ?? '';
        $user_phone     = $teslimat["telefon"] ?? '';
        $merchant_ok_url   = URL . "odeme-basarili";
        $merchant_fail_url = URL . "odeme-basarisiz";

        $basket = [];
        if (isset($sepet["urunler"]) && is_array($sepet["urunler"])) {
            foreach ($sepet["urunler"] as $urun) {
                $basket[] = [$urun["adi"], $urun["fiyat"], $urun["adet"]];
            }
        }
        $user_basket = base64_encode(json_encode($basket));

        $ip = $_SERVER["HTTP_CLIENT_IP"] ?? ($_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"]);
        $user_ip        = $ip;
        $timeout_limit  = "30";
        $debug_on       = 1;
        $test_mode      = 0;

        $no_installment     = isset($_SESSION["odeme_method_sub"]) && $_SESSION["odeme_method_sub"] == "pesin" ? 1 : 0;
        $max_installment    = $no_installment == 1 ? 0 : 12;
        $currency           = "TL";

        $hash_str       = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token    = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        $post_vals = [
            'merchant_id'       => $merchant_id,
            'user_ip'           => $user_ip,
            'merchant_oid'      => $merchant_oid,
            'email'             => $email,
            'payment_amount'    => $payment_amount,
            'paytr_token'       => $paytr_token,
            'user_basket'       => $user_basket,
            'debug_on'          => $debug_on,
            'no_installment'    => $no_installment,
            'max_installment'   => $max_installment,
            'user_name'         => $user_name,
            'user_address'      => $user_address,
            'user_phone'        => $user_phone,
            'merchant_ok_url'   => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit'     => $timeout_limit,
            'currency'          => $currency,
            'test_mode'         => $test_mode
        ];

        // cURL İstek Süreci
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            return ['success' => false, 'message' => 'PAYTR iFrame bağlantı hatası: ' . curl_error($ch)];
        }
        curl_close($ch);

        $result = json_decode($result, true);

        if (isset($result['status']) && $result['status'] == 'success') {
            return ['success' => true, 'gateway' => 'paytr', 'token' => $result['token']];
        } else {
            return ['success' => false, 'message' => 'PAYTR iFrame başarısız. Sebep: ' . ($result['reason'] ?? 'Bilinmeyen hata')];
        }
    }

    private function iyzicoEntegrasyon($siparis, $teslimat, $sepet, $ekVeriler, $ayar) {
        $api_key    = $ayar['api_key'] ?? '';
        $secret_key = $ayar['secret_key'] ?? '';
        
        $base_url   = $ayar['base_url'] ?? 'https://api.iyzipay.com'; 

        if (!class_exists('IyzipayBootstrap')) {
            require_once('Iyzico/IyzipayBootstrap.php');
            IyzipayBootstrap::init();
        }

        $options = new \Iyzipay\Options();
        $options->setApiKey($api_key);
        $options->setSecretKey($secret_key);
        $options->setBaseUrl($base_url);

        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($siparis['takip_no'] ?? ($siparis['siparis_kodu'] ?? 'SIP123'));

        
        $tutar = $siparis['fiyat'] ?? ($siparis['genel_toplam'] ?? 0);
        $request->setPrice($tutar);
        $request->setPaidPrice($tutar);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(URL . "odeme-sonuc/");
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $musteri_id = $ekVeriler["musteri_id"];
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("B" . $musteri_id);
        
        $adSoyad = $teslimat["ad_soyad"] ?? 'Misafir Müşteri';
        $buyer->setName(explode(" ", $adSoyad)[0] ?? $adSoyad);
        $buyer->setSurname(trim(str_replace($buyer->getName(), "", $adSoyad)) ?: 'Musteri');
        $buyer->setGsmNumber($teslimat["telefon"] ?? '05000000000');
        $buyer->setEmail($teslimat["email"] ?? '');
        $buyer->setIdentityNumber("11111111111");
        $buyer->setRegistrationAddress($teslimat["adres"] ?? 'Adres belirtilmemiş');
        $buyer->setIp($ekVeriler['gelen_ip'] ?? '127.0.0.1');
        $buyer->setCity($ekVeriler['sehir_adi'] ?? 'Istanbul');
        $buyer->setCountry("Turkey");
        $buyer->setZipCode($teslimat["posta_kodu"] ?? '34000');
        $request->setBuyer($buyer);

        // Teslimat Adresi
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($adSoyad);
        $shippingAddress->setCity($ekVeriler['sehir_adi'] ?? 'Istanbul');
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress($teslimat["adres"] ?? 'Adres belirtilmemiş');
        $shippingAddress->setZipCode($teslimat["posta_kodu"] ?? '34000');
        $request->setShippingAddress($shippingAddress);

        // Fatura Adresi
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($adSoyad);
        $billingAddress->setCity($ekVeriler['sehir_adi'] ?? 'Istanbul');
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($teslimat["adres"] ?? 'Adres belirtilmemiş');
        $billingAddress->setZipCode($teslimat["posta_kodu"] ?? '34000');
        $request->setBillingAddress($billingAddress);

        // Sepet Ürünleri 
        $basketItems = array();
        if (isset($sepet["sepet"]["urunler"]) && is_array($sepet["sepet"]["urunler"])) {
            foreach ($sepet["sepet"]["urunler"] as $key => $urun) {
                $kategoriAdi = "Genel";
                
                if(isset($urun['kategori']) && !empty($urun['kategori'])) {
                    $katSorgu = $this->db->prepare("SELECT kategori_adi FROM i_kategoriler WHERE id = ? LIMIT 1");
                    $katSorgu->execute([$urun['kategori']]);
                    $katCek = $katSorgu->fetch(PDO::FETCH_ASSOC);
                    if($katCek) $kategoriAdi = $katCek['kategori_adi'];
                }

                $basketItem = new \Iyzipay\Model\BasketItem();
                $basketItem->setId($urun['id'] ?? $key);
                $basketItem->setName($urun["adi"] ?? 'Ürün');
                $basketItem->setCategory1($kategoriAdi);
                $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $basketItem->setPrice(($urun["fiyat"] ?? 0) * ($urun["adet"] ?? 1));
                $basketItems[] = $basketItem;
            }
        }
        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

        if ($checkoutFormInitialize->getStatus() == 'success') {
            return [
                'success' => true,
                'gateway' => 'iyzico',
                'checkout_content' => $checkoutFormInitialize->getCheckoutFormContent()
            ];
        } else {
            return [
                'success' => false,
                'message' => 'İyzico Form Hatası: ' . $checkoutFormInitialize->getErrorMessage()
            ];
        }
    }

    private function mokaEntegrasyon($siparis, $ekVeriler, $ayar) {
        $dealer_code = $ayar['moka_id'] ?? '';
        $username    = $ayar['moka_username'] ?? '';
        $password    = $ayar['moka_password'] ?? '';
        
        $moka_url    = "https://service.mokaunited.com/PaymentDealer/DoDirectPaymentThreeD";
        $currency    = "TL";
        $InstallmentNumber = $ekVeriler['taksit'] ?? 1;
        
        $OtherTrxCode = $ekVeriler['siparis_id'];
        $RedirectUrl  = URL . "odeme-sonuc?MyTrxCode=" . $OtherTrxCode;

        $checkkey = hash("sha256", $dealer_code . "MK" . $username . "PD" . $password);
        $clean_pan = str_replace(' ', '', $ekVeriler['pan'] ?? '');

        $veri = array(
            'PaymentDealerAuthentication' => array(
                'DealerCode' => $dealer_code,
                'Username'   => $username,
                'Password'   => $password,
                'CheckKey'   => $checkkey
            ),
            'PaymentDealerRequest' => array(
                'CardHolderFullName' => $ekVeriler['name'] ?? '',
                'CardNumber'         => $clean_pan,
                'ExpMonth'           => $ekVeriler['month'] ?? '',
                'ExpYear'            => '20' . ($ekVeriler['year'] ?? ''),
                'CvcNumber'          => $ekVeriler['cv2'] ?? '',
                'Amount'             => $siparis['fiyat'],
                'Currency'           => $currency,
                'InstallmentNumber'  => $InstallmentNumber,
                'ClientIP'           => $_SERVER['REMOTE_ADDR'],
                'RedirectUrl'        => $RedirectUrl,
                'OtherTrxCode'       => $OtherTrxCode,
                'SubMerchantName'    => ""
            )
        );

        $jsonData = json_encode($veri);
        $ch = curl_init($moka_url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch); 
        curl_close($ch);
        $result = json_decode($result);

        if(isset($result->ResultCode) && $result->ResultCode == 'Success'){
            return [
                'success' => true,
                'gateway' => 'moka',
                'redirect_url' => $result->Data
            ];
        } else {
            $res_code = $result->ResultCode ?? '';
            
            $hata_sozlugu = [
            'PaymentDealer.CheckPaymentDealerAuthentication.InvalidRequest' => 'CheckKey hatalı ya da nesne hatalı ya da JSON bozuk olabilir.',
            'PaymentDealer.CheckPaymentDealerAuthentication.InvalidAccount' => 'Böyle bir bayi bulunamadı.',
            'PaymentDealer.CheckPaymentDealerAuthentication.VirtualPosNotFound' => 'Bu bayi için sanal pos tanımı yapılmamış.',
            'PaymentDealer.CheckDealerPaymentLimits.DailyDealerLimitExceeded' => 'Bayi için tanımlı günlük limitlerden herhangi biri aşıldı.',
            'PaymentDealer.CheckDealerPaymentLimits.DailyCardLimitExceeded' => 'Gün içinde bu kart kullanılarak daha fazla işlem yapılamaz.',
            'PaymentDealer.CheckCardInfo.InvalidCardInfo' => 'Kart bilgilerinde hata vardır. Bilgilerinizi kontrol ediniz.',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidRequest' => 'JSON objesi yanlış oluşturulmuş.',
            'PaymentDealer.DoDirectPayment3dRequest.RedirectUrlRequired' => '3D ödeme sonucunun döneceği RedirectURL verilmemiş.',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidCurrencyCode' => 'Para birimi hatalı. (TL, USD, EUR şeklinde olmalı)',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidInstallmentNumber' => 'Geçersiz taksit sayısı girilmiş 1-12 arası olmalıdır.',
            'PaymentDealer.DoDirectPayment3dRequest.InstallmentNotAvailableForForeignCurrencyTransaction' => 'Yabancı para ile taksit yapılamaz.',
            'PaymentDealer.DoDirectPayment3dRequest.ForeignCurrencyNotAvailableForThisDealer' => 'Bayinin yabancı parayla ödeme izni yok.',
            'PaymentDealer.DoDirectPayment3dRequest.PaymentMustBeAuthorization' => 'Ön otorizasyon tipinde ödeme gönderilmeli.',
            'PaymentDealer.DoDirectPayment3dRequest.AuthorizationForbiddenForThisDealer' => 'Bayinin ön otorizasyon tipinde ödeme gönderme izni yok.',
            'PaymentDealer.DoDirectPayment3dRequest.PoolPaymentNotAvailableForDealer' => 'Bayinin havuzlu ödeme gönderme izni yok.',
            'PaymentDealer.DoDirectPayment3dRequest.PoolPaymentRequiredForDealer' => 'Bayi sadece havuzlu ödeme gönderebilir.',
            'PaymentDealer.DoDirectPayment3dRequest.TokenizationNotAvailableForDealer' => 'Bayinin kart saklama izni yok.',
            'PaymentDealer.DoDirectPayment3dRequest.CardTokenCannotUseWithSaveCard' => 'Kart saklanmak isteniyorsa Token gönderilemez.',
            'PaymentDealer.DoDirectPayment3dRequest.CardTokenNotFound' => 'Gönderilen Token bulunamadı.',
            'PaymentDealer.DoDirectPayment3dRequest.OnlyCardTokenOrCardNumber' => 'Hem kart numarası hem de Token aynı anda verilemez.',
            'PaymentDealer.DoDirectPayment3dRequest.ChannelPermissionNotAvailable' => 'Bayinin bu kanaldan ödeme gönderme izni yok.',
            'PaymentDealer.DoDirectPayment3dRequest.IpAddressNotAllowed' => 'Bayinin IP kısıtlaması var, sadece önceden belirtilen IP den ödeme gönderebilir.',
            'PaymentDealer.DoDirectPayment3dRequest.VirtualPosNotAvailable' => 'Girilen kart için uygun sanal pos bulunamadı.',
            'PaymentDealer.DoDirectPayment3dRequest.ThisInstallmentNumberNotAvailableForVirtualPos' => 'Sanal Pos bu taksit sayısına izin vermiyor.',
            'PaymentDealer.DoDirectPayment3dRequest.ThisInstallmentNumberNotAvailableForDealer' => 'Bu taksit sayısı bu bayi için yapılamaz.',
            'PaymentDealer.DoDirectPayment3dRequest.DealerCommissionRateNotFound' => 'Bayiye bu sanal pos ve taksit için komisyon oranı girilmemiş.',
            'PaymentDealer.DoDirectPayment3dRequest.DealerGroupCommissionRateNotFound' => 'Üst bayiye bu sanal pos ve taksit için komisyon oranı girilmemiş.',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidSubMerchantName' => 'Gönderilen bayi adı daha önceden Moka United sistemine kaydedilmemiş.',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidUnitPrice' => 'Satılan ürünler sepete eklendiyse, geçerli birim fiyatı girilmelidir.',
            'PaymentDealer.DoDirectPayment3dRequest.InvalidQuantityValue' => 'Satılan ürünler sepete eklendiyse, geçerli adet girilmelidir.',
            'PaymentDealer.DoDirectPayment3dRequest.BasketAmountIsNotEqualPaymentAmount' => 'Satılan ürünler sepete eklendiyse, sepet tutarı ile ödeme tutarı eşleşmelidir.',
            'PaymentDealer.DoDirectPayment3dRequest.BasketProductNotFoundInYourProductList' => 'Satılan ürünler sepete eklendiyse, geçerli ürün seçilmelidir.',
            'PaymentDealer.DoDirectPayment3dRequest.MustBeOneOfDealerProductIdOrProductCode' => 'Satılan ürünler sepete eklendiyse, ürün kodu veya Moka United ürün ID si girilmelidir.',
            'EX' => 'Beklenmeyen bir hata oluştu.'
        ];

            $error_msg = $hata_sozlugu[$res_code] ?? ($result->ResultMessage ?? "Kart bilgileri doğrulanamadı. (Kod: ".$res_code.")");
            return [
                'success' => false,
                'message' => $error_msg
            ];
        }
    }
    
}