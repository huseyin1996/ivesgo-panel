<?php 
$ileti = '<div class="rcmBody" id="message-htmlpart1" style=" margin: 0; padding: 50px 0; width: 100%; max-width: 100%; background-color: #f3f4f6; color: #566593; font-family: &quot;Poppins&quot;, sans-serif; font-size: 14px; font-weight: 400; line-height: 21px; " >
    <table style="border: 0; max-width: 570px; margin: 0 auto">
        <tbody>
            <tr>
                <td>
                    <div style="margin-bottom: 30px; text-align: center">
                        <img src="'.URL.'assets/images/logo/'.$ayar['koyu_logo'].'" alt="'.$bloklar['firma_adi'].'" style="width: 135px; max-width: 100%" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="background-color: #ffffff; border-radius: 10px">
                        <div style="position: relative; z-index: 1; text-align: center">
                            <img src="'.URL.'assets/images/system/icon-header-info.png" alt="Bilgi" style="width: auto; max-width: 100%" />
                        </div>
                        <div style="padding: 30px 20px">
                            <h1 style=" margin: 0 0 20px 0; padding: 0; color: #0f2666; font-size: 18px; font-weight: 600 !important;"> '.$konu.' </h1>
                            <div>
                                '.$aciklama.'
                            </div>
                        </div>
                        <div style=" padding: 20px; background-color: #f3f4f7; border: 1px solid #ffffff; border-top: 1px solid #cfd4e0; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; color: #6f7da3; font-size: 12px; " >
                            <div style="color: #00004a; font-weight: 600">DİKKAT !</div>
                            <div>
                                KVKK kanunu kapsamında kişisel bilgilerin mail ile iletilmesi risk oluşturabileceği için sadece genel bilgiler içermektedir.  Bu bilgileri kimse ile paylaşmamanız gerekmektedir.
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style=" width: 500px; max-width: 100%; margin: 30px auto 0; color: #909396; font-size: 10px; line-height: 18px; text-align: center; " >
                        <p>
                            '.$bloklar['firma_adi'].' <br />
                            '.$site_iletisim['2'].' <br />
                            '.$site_iletisim['3'].' <br />
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>';
$ileti = trim($ileti);