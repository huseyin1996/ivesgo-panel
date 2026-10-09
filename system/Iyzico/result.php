<?php
require_once('config.php');
$siparis_id = $_GET["o_id"];


$token=$_POST["token"];
# create request class
$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId($siparis_id);
$request->setToken($token);

# make request
$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

# print result
//print_r($checkoutForm->getStatus());
//print_r($checkoutForm->getPaymentStatus());
//print_r($checkoutForm->getErrorMessage());


if ($checkoutForm->getPaymentStatus()!=SUCCESS and $checkoutForm->getStatus()==success) {
    
    //SİPARİŞ-GÜNCELLEME
    $siparis_varmi = $db->prepare("SELECT * FROM iv_orders WHERE o_id = ?");
    $siparis_varmi->execute([$siparis_id]);
    if($siparis_varmi->rowCount()){
        $siparis_guncelle = $db->query("UPDATE iv_orders SET o_durum = 1 WHERE o_id = '{$siparis_id}'");
        if($siparis_guncelle){
            $_SESSION["siparis_id"] = $siparis_id;
            echo '<meta http-equiv="refresh" content="0;URL=https://nggjewelz.com/index.php?sayfa=odeme-sonuc&odeme=true">';
        }
    }
?>

	<?php 
	
}else{

	?>
	<meta http-equiv="refresh" content="0;URL=https://nggjewelz.com/index.php?sayfa=odeme-sonuc&odeme=false">

	<?php 

} ?>