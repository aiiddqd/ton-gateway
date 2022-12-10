<?php
namespace Examples;

require __DIR__ . '/../vendor/autoload.php';
use TelePay\TelePayClient;
use TelePay\TelePayEnvironment;


$clientSecret = "YOUR SECRET";
$environment = new TelePayEnvironment($clientSecret);

$telepay = new TelePayClient($environment);

$me = $telepay->getMe();
$merchant = $me['merchant'];
$merchantName = $merchant['name'];
$merchantUrl = $merchant['url'];
$merchantUsername = $merchant['username'];
$merchantPublicProfile = $merchant['public_profile'];

$balance = $telepay->getBalance();
$wallets = $balance['wallets'];
echo "My wallets: \n";
foreach ($wallets as $wallet) {
    echo "Asset:  ".$wallet['asset']
        ." Blockchain: ".$wallet['blockchain']
        ." Networks: ".$wallet['network']
        ." balance: ".$wallet['balance']
        ."\n";
}

$invoicesResponse = $telepay->getInvoices();
$invoices = $invoicesResponse['invoices'];
echo "My invoices: \n";
foreach ($invoices as $invoice) {
    echo "Number:  ".$invoice['number']."\n"
        ." description: ".$invoice['description']."\n"
        ."Asset:  ".$invoice['asset']."\n"
        ." Blockchain: ".$invoice['blockchain']."\n"
        ." Networks: ".$invoice['network']."\n"
        ." status: ".$invoice['status']."\n"
        ." amount: ".$invoice['amount']."\n"
        ."\n";
}