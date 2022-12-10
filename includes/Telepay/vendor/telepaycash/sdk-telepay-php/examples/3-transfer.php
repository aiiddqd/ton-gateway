<?php
namespace Examples;

require __DIR__ . '/../vendor/autoload.php';

use TelePay\TelePayClient;
use TelePay\TelePayException;
use TelePay\TelePayEnvironment;
use TelePay\TelePayTransferInput;

try {
    $clientSecret = "YOUR SECRET";
    
    $telepay = new TelePayClient(new TelePayEnvironment($clientSecret));
    
    $transfer = new TelePayTransferInput("TON", "TON", "testnet", "0.2", "raubel1993");
    $transfer->setMessage("Debt settled");
    
    $respTransfer= $telepay->transfer($transfer);
    print_r($respTransfer);
} catch (TelePayException $th) {
    print_r([
        "statusCode" => $th->getStatusCode(),
        "error" => $th->getError(),
        "message" => $th->getMessage(),
    ]);
}catch (\Throwable $th) {
    throw $th;
}