<?php

namespace TelePay;

/**
 * TelePayBaseInput is the base class for all input classes when asset, blockchain, network and amount are required.
 */
abstract class TelePayBaseInput
{
    /** @var string $asset*/
    protected $asset;

    /** @var string $blockchain*/
    protected $blockchain;

    /** @var string||null $network*/
    protected $network;

    /** @var double $amount*/
    protected $amount;

    /**
     * Construct
     * @param string $asset
     * @param string $blockchain
     * @param string|null $network
     * @param double $amount
     */
    public function __construct($asset, $blockchain, $network, $amount)
    {
        $this->setAsset($asset);
        $this->setBlockchain($blockchain);
        $this->setNetwork($network);
        $this->setAmount($amount);
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
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
