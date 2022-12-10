<?php

namespace TelePay;

/**
 * This class is a input when asset, blockchain, network.
 */
class TelePayAssetInput
{
    /** @var string $asset*/
    protected $asset;

    /** @var string $blockchain*/
    protected $blockchain;

    /** @var string $network*/
    protected $network;

    /**
     * Constructor.
     * 
     * @param string asset
     * @param string blockchain
     * @param string network
     */
    public function __construct($asset, $blockchain, $network = null)
    {
        $this->setAsset($asset);
        $this->setBlockchain($blockchain);
        if($network) {
            $this->setNetwork($network);
        }
    }
    public function getBodyPrepared()
    {
        $body = array(
            "asset" => $this->asset,
            "blockchain" => $this->blockchain,
            "network" => $this->network
        );
        return $body;
    }

    public function getAsset()
    {
        return $this->asset;
    }
    public function setAsset($asset)
    {
        $this->asset = $asset;
    }
    public function getBlockchain()
    {
        return $this->blockchain;
    }
    public function setBlockchain($blockchain)
    {
        $this->blockchain = $blockchain;
    }
    public function getNetwork()
    {
        return $this->network;
    }
    public function setNetwork($network)
    {
        $this->network = $network;
    }
}