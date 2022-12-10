<?php
namespace Examples;

require __DIR__ . '/../vendor/autoload.php';
use TelePay\TelePayClient;
use TelePay\TelePayEnvironment;
use TelePay\TelePayInvoiceInput;

$clientSecret = "YOUR SECRET";

$orderId = 56;

$telepay = new TelePayClient(new TelePayEnvironment($clientSecret));

$invoice = new TelePayInvoiceInput("TON", "TON", "mainnet", "0.5");
$invoice->setDescription("Test using SDK TelePay PHP");
$invoice->setMetadata([
    "my_reference_id" => $orderId,
    "other_metadata" => "any value"
]);
$invoice->setSuccessUrl("https://www.example.com/payment_success?order_id=$orderId");
$invoice->setCancelUrl("https://www.example.com/payment_cancelled?order_id=$orderId");

$respCreateInvoice = $telepay->createInvoice($invoice);
$invoiceNumber = $respCreateInvoice['number'];
print_r($respCreateInvoice);

$respGetInvoice = $telepay->getInvoice($invoiceNumber);
print_r($respGetInvoice);