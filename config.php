<?php
    date_default_timezone_set("Africa/Nairobi");
    
    define('CONSUMER_KEY', 'ONo2MJYWkrTMsPwNiU6BqUrKGtSaHTkm');
    define('CONSUMER_SECRET', 'T6AUvMmIRPEpQCRL');

    $env = 0;
    $ssl = true;

    $ShortCode = '174379';
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    
    
    if ($env == 1) {
        define('STATE', 'api');
    } else {
        define('STATE', 'sandbox');
    }

    $base_sec = $ssl === true ? 'https://' : 'http://';
  
    $Timestamp = date('YmdHis');
    $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

    /* lnmo api urls */
    define('LNMO_CALLBACK_URL', 'https://08fa-102-167-27-228.ngrok-free.app/payment/lnmo.php?oid=');
