<?php

namespace Test\Asset;

use Test\TestInit;
use TelePay\TelePayException;
use PHPUnit\Framework\TestCase;
use TelePay\TelePayEvents;
use TelePay\TelePayWebhookInput;

class WebhookTest extends TestCase
{
    private $url = "https://www.example.com/webhook";
    private $secret = "secret";
    private $events = [
        TelePayEvents::ALL
    ];

    public function testCreateWebhookSuccessfull()
    {
        $telepay = TestInit::client();

        $newWebhook = new TelePayWebhookInput($this->url, $this->secret, $this->events);

        $webhook = $telepay->createWebhook($newWebhook);

        $this->assertNotNull($webhook);
        $this->assertArrayHasKey('id', $webhook);
        $this->assertNotNull($webhook['id']);

        $this->assertArrayHasKey('url', $webhook);
        $this->assertNotNull($webhook['url']);
        $this->assertEquals($this->url, $webhook['url']);

        $this->assertArrayHasKey('secret', $webhook);
        $this->assertNotNull($webhook['secret']);
        $this->assertEquals($this->secret, $webhook['secret']);

        $this->assertArrayHasKey('active', $webhook);
        $this->assertNotNull($webhook['active']);

        $this->assertArrayHasKey('events', $webhook);
        $this->assertNotNull($webhook['events']);
        $this->assertEquals($this->events, $webhook['events']);

        return $webhook['id'];
    }

    /**
     * @depends testCreateWebhookSuccessfull
     */
    public function testGetWebhookByNumber($webhookNumber)
    {
        $telepay = TestInit::client();
        $webhook = $telepay->getWebhook($webhookNumber);

        $this->assertNotNull($webhook);
        $this->assertArrayHasKey('id', $webhook);
        $this->assertNotNull($webhook['id']);

        $this->assertArrayHasKey('url', $webhook);
        $this->assertNotNull($webhook['url']);
        $this->assertEquals($this->url, $webhook['url']);

        $this->assertArrayHasKey('secret', $webhook);
        $this->assertNotNull($webhook['secret']);
        $this->assertEquals($this->secret, $webhook['secret']);

        $this->assertArrayHasKey('active', $webhook);
        $this->assertNotNull($webhook['active']);

        $this->assertArrayHasKey('events', $webhook);
        $this->assertNotNull($webhook['events']);
        $this->assertEquals($this->events, $webhook['events']);

        return $webhookNumber;
    }

    /**
     * @depends testGetWebhookByNumber
     */
    public function testDeactivateWebhook($webhookNumber)
    {
        $telepay = TestInit::client();

        $webhook = $telepay->deactivateWebhook($webhookNumber);

        $this->assertNotNull($webhook);
        $this->assertArrayHasKey('active', $webhook);
        $this->assertEquals($webhook['active'], false);

        return $webhookNumber;
    }

    /**
     * @depends testDeactivateWebhook
     */
    public function testUpdateWebhook($webhookNumber)
    {
        $telepay = TestInit::client();

        $newSecret = "newSecret";
        $updateWebhook = new TelePayWebhookInput($this->url, $newSecret, $this->events, false);

        $webhook = $telepay->updateWebhook($webhookNumber, $updateWebhook);

        $this->assertNotNull($webhook);
        $this->assertArrayHasKey('id', $webhook);
        $this->assertEquals($webhook['id'], $webhookNumber);
        $this->assertArrayHasKey('secret', $webhook);
        $this->assertEquals($webhook['secret'], $newSecret);
        $this->assertArrayHasKey('active', $webhook);

        return $webhookNumber;
    }

    /**
     * @depends testUpdateWebhook
     */
    public function testActivateWebhook($webhookNumber)
    {
        $telepay = TestInit::client();

        $webhook = $telepay->activateWebhook($webhookNumber);

        $this->assertNotNull($webhook);
        $this->assertArrayHasKey('active', $webhook);
        $this->assertEquals($webhook['active'], true);

        return $webhookNumber;
    }

    /**
     * @depends testActivateWebhook
     */
    public function testDeleteWebhookByNumber($webhookNumber)
    {
        $telepay = TestInit::client();
        $reesponse = $telepay->deleteWebhook($webhookNumber);
        $this->assertNotNull($reesponse);
        $this->assertArrayHasKey('success', $reesponse);
        $this->assertEquals($reesponse['success'], 'webhook.deleted');
    }
}
