<?php

namespace Test\Asset;


use Test\TestInit;
use TelePay\TelePayException;
use PHPUnit\Framework\TestCase;
use TelePay\TelePayInvoiceInput;

class InvoiceTest extends TestCase
{
    private $asset = "TON";
    private $blockchain = "TON";
    private $network = "testnet";
    private $amount = 1.0;
    private $description = "Test Description";
    private $metadata = [
        "my_reference_id" => 20,
        "other_metadata" => "any value"
    ];
    private $success_url = "https://www.example.com/payment_success?order_id=20";
    private $cancel_url = "https://www.example.com/payment_cancelled?order_id=20";

    public function testCreateInvoiceSuccessfull()
    {
        $telepay = TestInit::client();

        $newInvoice = new TelePayInvoiceInput($this->asset, $this->blockchain, $this->network,  $this->amount);
        $newInvoice->setDescription($this->description);
        $newInvoice->setMetadata($this->metadata);
        $newInvoice->setSuccessUrl($this->success_url);
        $newInvoice->setCancelUrl($this->cancel_url);

        $invoice = $telepay->createInvoice($newInvoice);

        $this->assertNotNull($invoice);
        $this->assertArrayHasKey('number', $invoice);
        $this->assertNotNull($invoice['number']);

        $this->assertArrayHasKey('asset', $invoice);
        $this->assertNotNull($invoice['asset']);
        $this->assertEquals($this->asset, $invoice['asset']);

        $this->assertArrayHasKey('blockchain', $invoice);
        $this->assertNotNull($invoice['blockchain']);
        $this->assertEquals($this->blockchain, $invoice['blockchain']);

        $this->assertArrayHasKey('network', $invoice);
        $this->assertNotNull($invoice['network']);
        $this->assertEquals($this->network, $invoice['network']);

        $this->assertArrayHasKey('amount', $invoice);
        $this->assertNotNull($invoice['amount']);
        $this->assertTrue( $this->amount == $invoice['amount']);

        $this->assertArrayHasKey('description', $invoice);
        $this->assertNotNull($invoice['description']);
        $this->assertEquals($this->description, $invoice['description']);

        $this->assertArrayHasKey('metadata', $invoice);
        $this->assertNotNull($invoice['metadata']);
        $this->assertEquals($this->metadata, $invoice['metadata']);

        $this->assertArrayHasKey('success_url', $invoice);
        $this->assertNotNull($invoice['success_url']);
        $this->assertEquals($this->success_url, $invoice['success_url']);

        $this->assertArrayHasKey('cancel_url', $invoice);
        $this->assertNotNull($invoice['cancel_url']);
        $this->assertEquals($this->cancel_url, $invoice['cancel_url']);

        $this->assertArrayHasKey('status', $invoice);
        $this->assertNotNull($invoice['status']);
        $this->assertEquals('pending', $invoice['status']);

        $this->assertArrayHasKey('checkout_url', $invoice);
        $this->assertNotNull($invoice['checkout_url']);

        $this->assertArrayHasKey('onchain_url', $invoice);
        $this->assertNotNull($invoice['onchain_url']);

        return $invoice['number'];
    }

    public function testCreateInvoiceFail()
    {
        $telepay = TestInit::client();

        $unexistentAsset = "UNEXISTENT";

        $newInvoice = new TelePayInvoiceInput($unexistentAsset, $this->blockchain, $this->network,  $this->amount);
        $newInvoice->setDescription($this->description);
        $newInvoice->setMetadata($this->metadata);
        $newInvoice->setSuccessUrl($this->success_url);
        $newInvoice->setCancelUrl($this->cancel_url);

        try {
            $telepay->createInvoice($newInvoice);
            $this->fail('TelePayException was not thrown');
        } catch (TelePayException $exception) {
            $this->assertEquals(401, $exception->getStatusCode());
            $this->assertEquals('INVALID_ASSET_BLOCKCHAIN_NETWORK_COMBINATION', $exception->getError());
        }
    }

    /**
     * @depends testCreateInvoiceSuccessfull
     */
    public function testGetInvoiceByNumber($invoiceNumber)
    {
        $telepay = TestInit::client();
        $invoice = $telepay->getInvoice($invoiceNumber);

        $this->assertNotNull($invoice);
        $this->assertArrayHasKey('number', $invoice);
        $this->assertNotNull($invoice['number']);

        $this->assertArrayHasKey('asset', $invoice);
        $this->assertNotNull($invoice['asset']);
        $this->assertEquals($this->asset, $invoice['asset']);

        $this->assertArrayHasKey('blockchain', $invoice);
        $this->assertNotNull($invoice['blockchain']);
        $this->assertEquals($this->blockchain, $invoice['blockchain']);

        $this->assertArrayHasKey('network', $invoice);

        $this->assertArrayHasKey('amount', $invoice);
        $this->assertNotNull($invoice['amount']);
        $this->assertEquals((float) $this->amount, $invoice['amount']);

        $this->assertArrayHasKey('description', $invoice);
        $this->assertNotNull($invoice['description']);
        $this->assertEquals($this->description, $invoice['description']);

        $this->assertArrayHasKey('metadata', $invoice);
        $this->assertNotNull($invoice['metadata']);
        $this->assertEquals($this->metadata, $invoice['metadata']);

        $this->assertArrayHasKey('success_url', $invoice);
        $this->assertNotNull($invoice['success_url']);
        $this->assertEquals($this->success_url, $invoice['success_url']);

        $this->assertArrayHasKey('cancel_url', $invoice);
        $this->assertNotNull($invoice['cancel_url']);
        $this->assertEquals($this->cancel_url, $invoice['cancel_url']);

        $this->assertArrayHasKey('status', $invoice);
        $this->assertNotNull($invoice['status']);
        $this->assertEquals('pending', $invoice['status']);

        $this->assertArrayHasKey('checkout_url', $invoice);
        $this->assertNotNull($invoice['checkout_url']);

        $this->assertArrayHasKey('onchain_url', $invoice);
        $this->assertNotNull($invoice['onchain_url']);

        return $invoiceNumber;
    }

    /**
     * @depends testGetInvoiceByNumber
     */
    public function testCancelInvoiceByNumber($invoiceNumber)
    {
        $telepay = TestInit::client();
        $invoice = $telepay->cancelInvoice($invoiceNumber);

        $this->assertNotNull($invoice);
        $this->assertArrayHasKey('number', $invoice);
        $this->assertNotNull($invoice['number']);

        $this->assertArrayHasKey('asset', $invoice);
        $this->assertNotNull($invoice['asset']);
        $this->assertEquals($this->asset, $invoice['asset']);

        $this->assertArrayHasKey('blockchain', $invoice);
        $this->assertNotNull($invoice['blockchain']);
        $this->assertEquals($this->blockchain, $invoice['blockchain']);

        $this->assertArrayHasKey('network', $invoice);
        $this->assertEquals($this->network, $invoice['network']);

        $this->assertArrayHasKey('amount', $invoice);
        $this->assertNotNull($invoice['amount']);
        $this->assertEquals((float) $this->amount, $invoice['amount']);

        $this->assertArrayHasKey('description', $invoice);
        $this->assertNotNull($invoice['description']);
        $this->assertEquals($this->description, $invoice['description']);

        $this->assertArrayHasKey('metadata', $invoice);
        $this->assertNotNull($invoice['metadata']);
        $this->assertEquals($this->metadata, $invoice['metadata']);

        $this->assertArrayHasKey('success_url', $invoice);
        $this->assertNotNull($invoice['success_url']);
        $this->assertEquals($this->success_url, $invoice['success_url']);

        $this->assertArrayHasKey('cancel_url', $invoice);
        $this->assertNotNull($invoice['cancel_url']);
        $this->assertEquals($this->cancel_url, $invoice['cancel_url']);

        $this->assertArrayHasKey('status', $invoice);
        $this->assertNotNull($invoice['status']);
        $this->assertEquals('cancelled', $invoice['status']);

        $this->assertArrayHasKey('checkout_url', $invoice);
        $this->assertNotNull($invoice['checkout_url']);

        $this->assertArrayHasKey('onchain_url', $invoice);
        $this->assertNotNull($invoice['onchain_url']);


        $checkInvoice = $telepay->getInvoice($invoiceNumber);
        $this->assertNotNull($checkInvoice);
        $this->assertArrayHasKey('status', $checkInvoice);
        $this->assertEquals('cancelled', $checkInvoice['status']);

        return $invoiceNumber;
    }

    /**
     * @depends testCancelInvoiceByNumber
     */
    public function testDeleteInvoiceByNumber($invoiceNumber)
    {
        $telepay = TestInit::client();
        $reesponse = $telepay->deleteInvoice($invoiceNumber);
        $this->assertNotNull($reesponse);
        $this->assertArrayHasKey('status', $reesponse);
        $this->assertEquals('deleted', $reesponse['status']);
    }
}
