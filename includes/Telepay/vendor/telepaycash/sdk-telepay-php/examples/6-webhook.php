<?php
namespace Examples;

require __DIR__ . '/../vendor/autoload.php';
use TelePay\TelePayClient;
use TelePay\TelePayEvents;
use TelePay\TelePayEnvironment;
use TelePay\TelePayWebhookInput;

$clientSecret = "YOUR SECRET";

$telepay = new TelePayClient( new TelePayEnvironment($clientSecret));

$urlWebhook = "https://www.example.com/webhook";
$secretWebhook = "secret";
$eventsWebhook = [
    TelePayEvents::INVOICE_COMPLETED
];

$responseGetAllWebhooks = $telepay->getWebhooks();
foreach ($responseGetAllWebhooks['webhooks'] as $webhook) {
    $telepay->deleteWebhook($webhook['id']);
}

$webhookInput = new TelePayWebhookInput($urlWebhook, $secretWebhook, $eventsWebhook);

$responseCreateWebhook = $telepay->createWebhook($webhookInput);
print_r($responseCreateWebhook);

$responseGetOneWebhook = $telepay->getWebhook($responseCreateWebhook['id']);
print_r($responseGetOneWebhook);

$responseGetAllWebhooks = $telepay->getWebhooks();
print_r($responseGetAllWebhooks);

$responseDeactivateWebhook = $telepay->deactivateWebhook($responseCreateWebhook['id']);
print_r($responseDeactivateWebhook);

$webhookInput->setSecret("new secret");
$webhookInput->setActive(false);
$responseUpdateWebhook = $telepay->updateWebhook($responseCreateWebhook['id'], $webhookInput);
print_r($responseUpdateWebhook);

$responseActivateWebhook = $telepay->activateWebhook($responseCreateWebhook['id']);
print_r($responseActivateWebhook);

$responseDeleteWebhook = $telepay->deleteWebhook($responseCreateWebhook['id']);
print_r($responseDeleteWebhook);



