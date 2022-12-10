<?php

namespace tests\Wallet;

use Test\TestInit;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{

    public function testGetBalance()
    {
        $telepay = TestInit::client();

        $balance = $telepay->getBalance();

        $this->assertNotNull($balance);
        $this->assertArrayHasKey('wallets', $balance);

        $wallets = $balance['wallets'];
        $this->assertIsArray($wallets);
        $this->assertGreaterThanOrEqual(1, count($wallets));
        foreach ($wallets as $wallet) {
            $this->assertArrayHasKey('asset', $wallet);
            $this->assertNotNull($wallet['asset']);

            $this->assertArrayHasKey('blockchain', $wallet);
            $this->assertNotNull($wallet['blockchain']);

            $this->assertArrayHasKey('balance', $wallet);
            $this->assertNotNull($wallet['balance']);

            $this->assertArrayHasKey('network', $wallet);
        }
    }
}
