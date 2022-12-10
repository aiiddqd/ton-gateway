<?php

namespace TonGateway\TelepayShortcode;

use TelePay\TelePayEnvironment;
use TelePay\TelePayClient;
use TelePay\TelePayInvoiceInput;


add_shortcode('telepay', function ($args) {
    require_once(__DIR__ . '/Telepay/vendor/autoload.php');
    
});

function get_telepay(): ? TelePayClient {
    
    $payment_gateways = WC()->payment_gateways()->payment_gateways();
    if( ! isset($payment_gateways['telepay'])){
        return null;
    }
    $payment_gateway = $payment_gateways['telepay'];

    $secret_key = $payment_gateway->get_option('secret_key');
    if(empty($secret_key)){
        return null;
    }

    $environment = new TelePayEnvironment($secret_key);
    return new TelePayClient($environment);
}
