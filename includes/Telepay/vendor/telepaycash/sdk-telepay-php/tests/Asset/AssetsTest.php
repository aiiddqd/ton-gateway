<?php

namespace Test\Asset;


use Test\TestInit;
use PHPUnit\Framework\TestCase;

class AssetsTest extends TestCase
{
    public function testGetAssets()
    {
        $telepay = TestInit::client();

        $assets = $telepay->getAssets();

        $this->assertNotNull($assets);
        $this->assertArrayHasKey('assets', $assets);

        $assets = $assets['assets'];
        $this->assertIsArray($assets);
        $this->assertGreaterThanOrEqual(1, count($assets));
        foreach ($assets as $asset) {
            $this->assertArrayHasKey('asset', $asset);
            $this->assertNotNull($asset['asset']);

            $this->assertArrayHasKey('blockchain', $asset);
            $this->assertNotNull($asset['blockchain']);

            $this->assertArrayHasKey('url', $asset);
            $this->assertNotNull($asset['url']);

            $this->assertArrayHasKey('networks', $asset);

            $networks = $asset['networks'];
            $this->assertIsArray($networks);
            foreach ($networks as $network) {
                $this->assertIsString($network);
            }
        }
    }
}