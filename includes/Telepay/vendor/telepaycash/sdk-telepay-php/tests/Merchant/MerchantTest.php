<?php

namespace Test\Merchant;


use PHPUnit\Framework\TestCase;
use Test\TestInit;

class MerchantTest extends TestCase
{
    public function testGetMe()
    {
        $telepay = TestInit::client();

        $me = $telepay->getMe();
        $this->assertNotNull($me);
        $this->assertArrayHasKey('version', $me);
        $this->assertArrayHasKey('merchant', $me);

        $merchant = $me['merchant'];
        $this->assertArrayHasKey('name', $merchant);
        $this->assertArrayHasKey('url', $merchant);
        $this->assertArrayHasKey('logo_url', $merchant);
        $this->assertArrayHasKey('logo_thumbnail_url', $merchant);
        $this->assertArrayHasKey('verified', $merchant);
        $this->assertArrayHasKey('username', $merchant);
        $this->assertArrayHasKey('public_profile', $merchant);

        $this->assertArrayHasKey('owner', $merchant);

        $owner = $merchant['owner'];
        $this->assertNotNull($owner);
        $this->assertArrayHasKey('first_name', $owner);
        $this->assertArrayHasKey('last_name', $owner);
        $this->assertArrayHasKey('username', $owner);

        $this->assertArrayHasKey('created_at', $merchant);
        $this->assertArrayHasKey('updated_at', $merchant);
    }
}
