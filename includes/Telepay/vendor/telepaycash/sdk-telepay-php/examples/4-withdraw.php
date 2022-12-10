<?php
namespace Examples;

require __DIR__ . '/../vendor/autoload.php';

use TelePay\TelePayClient;
use TelePay\TelePayEnvironment;
use TelePay\TelePayWithdrawInput;
use TelePay\TelePayWithdrawMinimumInput;

$clientSecret = "YOUR SECRET";

$telepay = new TelePayClient(new TelePayEnvironment($clientSecret));

$withdrawMin = new TelePayWithdrawMinimumInput("TON", "TON", "testnet");
$resp = $telepay->getWithdrawMinimum($withdrawMin);
print_r($resp);

$withdraw = new TelePayWithdrawInput("TON", "TON", "testnet", "2", "EQCMwbXqm0ccV2zeInCszTRySGlJ4g3CcXA8D67qOqeCV7yU");
$withdraw->setMessage("for my savings account");

$respWithdrawFee = $telepay->getWithdrawFee($withdraw);
print_r($respWithdrawFee);

$respWithdraw = $telepay->withdraw($withdraw);
print_r($respWithdraw);
