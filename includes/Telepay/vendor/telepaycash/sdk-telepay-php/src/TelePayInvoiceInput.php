<?php

namespace TelePay;

/**
 * This class is the input to create a new invoice.
 */
class TelePayInvoiceInput  extends TelePayBaseInput
{
    /** 
     * @var string|null Description of the invoice 
     */
    private $description;

    /** 
     * @var array|null metadata of the invoice 
     */
    private $metadata;

    /** 
     * @var string|null success_url is the url to redirect when the payment is successful 
     */
    private $success_url;

    /** 
     * @var string|null cancel_url is the url to redirect when the payment is canceled 
     */
    private $cancel_url;

    /** 
     * @var int invoice expire time after created
     */
    private $expires_at;

    /**
     * Constructor.
     * 
     * @param string $asset
     * @param string $blockchain
     * @param string $network
     * @param double $amount
     */
    public function __construct($asset, $blockchain, $network, $amount)
    {
        parent::__construct($asset, $blockchain, $network, $amount);
        $this->setExpiresAt(600);
    }

    public function getBodyPrepared()
    {
        $body = array(
            "asset" => $this->asset,
            "blockchain" => $this->blockchain,
            "network" => $this->network,
            "amount" => $this->amount,
            "expires_at" => $this->expires_at
        );
        if ($this->description) {
            $body["description"] = $this->description;
        }
        if ($this->metadata) {
            $body["metadata"] = $this->metadata;
        }
        if ($this->success_url) {
            $body["success_url"] = $this->success_url;
        }
        if ($this->cancel_url) {
            $body["cancel_url"] = $this->cancel_url;
        }
        return $body;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getMetadata()
    {
        return $this->metadata;
    }
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }
    public function getSuccessUrl()
    {
        return $this->success_url;
    }
    public function setSuccessUrl($success_url)
    {
        $this->success_url = $success_url;
    }
    public function getCancelUrl()
    {
        return $this->cancel_url;
    }
    public function setCancelUrl($cancel_url)
    {
        $this->cancel_url = $cancel_url;
    }
    public function getExpiresAt()
    {
        return $this->expires_at;
    }
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
    }
}
