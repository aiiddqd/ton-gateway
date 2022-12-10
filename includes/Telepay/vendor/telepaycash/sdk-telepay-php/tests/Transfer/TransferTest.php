<?php

namespace Test\Transfer;

use Test\TestInit;
use PHPUnit\Framework\TestCase;
use TelePay\TelePayException;
use TelePay\TelePayTransferInput;

class TransferTest extends TestCase
{
    private $asset = "TON";
    private $blockchain = "TON";
    private $network = "testnet";
    private $amount = "0.2";
    private $message = "Debt settled";

    public function getUsername()
    {
        $username = getenv("USERNAME_TELEPAY_TRANSFER")  ?: "USERNAME_TELEPAY_TRANSFER";
        return $username;
    }

    public function testTransferenceSuccessfull()
    {
        $telepay = TestInit::client();

        $transfer = new TelePayTransferInput($this->asset, $this->blockchain, $this->network,  $this->amount, $this->getUsername());
        $transfer->setMessage($this->message);

        $respTransfer = $telepay->transfer($transfer);

        $this->assertNotNull($respTransfer);
        $this->assertArrayHasKey('success', $respTransfer);
        $this->assertEquals("transfer.ok", $respTransfer['success']);
    }

    public function testTransferenceFail()
    {
        $telepay = TestInit::client();

        $unexistentAsset = "UNEXISTENT";

        $transfer = new TelePayTransferInput($unexistentAsset, $this->blockchain, $this->network,  $this->amount, $this->getUsername());
        $transfer->setMessage($this->message);

        try {
            $telepay->transfer($transfer);
            $this->fail('TelePayException was not thrown');
        } catch (TelePayException $exception) {
            $this->assertEquals(401, $exception->getStatusCode());
            $this->assertEquals('INVALID_ASSET_BLOCKCHAIN_NETWORK_COMBINATION', $exception->getError());
        }
    }
}
