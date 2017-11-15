<?php
    /*
        * Config for PayPal specific values
    */
    //Whether Sandbox environment is being used, Keep it true for testing
    define("SANDBOX_FLAG", true);
    define("WEBHOOK_CONFIGURED", false);
    //PayPal REST API endpoints
    define("SANDBOX_ENDPOINT", "https://api.sandbox.paypal.com");
    define("LIVE_ENDPOINT", "https://api.paypal.com");
    //Environments -Sandbox and Production/Live
    define("SANDBOX_ENV", "sandbox");
    define("LIVE_ENV", "production");
     //Checkout URL
    define("CHECKOUT_START_URL",'http://'.$_SERVER['HTTP_HOST'].preg_replace('/checkout_1.php/','checkout_2.php?mode=ma',$_SERVER['SCRIPT_NAME']));
    define("CHECKOUT_RETURN_URL",'http://'.$_SERVER['HTTP_HOST'].preg_replace('/checkout_1.php/','checkout_3.php?mode=ma',$_SERVER['SCRIPT_NAME']));

    //Partner credentials
    define("PARTNER_ID","");
    define("PARTNER_BN_CODE", "");
    define("PARTNER_EMAIL", "");
    define("PARTNER_CLIENT_ID","");
    define("PARTNER_CLIENT_SECRET", "");

    define("PARTNER_NAME", "PartnerPlace");
    define("PARTNER_DOMAIN", "www.partnerplace.example.com");

    date_default_timezone_set('UTC');
    $date = date_create();
    $time_stamp_date= date_timestamp_get($date);
    define("TIME_STAMP", date_timestamp_get($date));
    //MAM call details
    define("COUNTRY_CODE", "");
    define("SELLER1_NAME", "");
    define("SELLER1_VAR", "");
    define("SELLER_1_EMAIL", "");
    define("SELLER2_NAME", "");
    define("SELLER2_VAR", "");
    define("SELLER_2_EMAIL", "");
    define("CURRENCY_CODE", "");

    //Seller Payer IDs
    define("SELLER_1_PAYER_ID", "");
    define("SELLER_2_PAYER_ID", "");

    define("PARTNER_CUSTOM", "custom_".date_timestamp_get($date));
    define("PARTNER_INVOICE", "invoice_".date_timestamp_get($date));
?>
