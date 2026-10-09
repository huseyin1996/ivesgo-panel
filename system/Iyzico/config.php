<?php
require_once('panel/config/ayar.php');
require_once('IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey(IYZICO_API_KEY);
        $options->setSecretKey(IYZICO_SECRET_KEY);
        $options->setBaseUrl("https://api.iyzipay.com");
        return $options;
    }
}