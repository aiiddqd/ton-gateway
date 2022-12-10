<?php

namespace TelePay;

/**
 * This class is the input to create a new transference.
 */
class TelePayTransferInput extends TelePayBaseInput
{
    /** 
     * @var string Username of the transference
     */
    private $username;

    /** 
     * @var string|null message of the transference 
     */
    private $message;

    /**
     * Constructor.
     * 
     * @param string $asset
     * @param string $blockchain
     * @param string $network
     * @param double $amount
     * @param string $username
     */
    public function __construct($asset, $blockchain, $network, $amount, $username)
    {
        parent::__construct($asset, $blockchain, $network, $amount);
        $this->setUsername($username);
    }
    public function getBodyPrepared()
    {
        $body = array(
            "asset" => $this->asset,
            "blockchain" => $this->blockchain,
            "network" => $this->network,
            "amount" => $this->amount,
            "username" => $this->username
        );
        if ($this->message) {
            $body["message"] = $this->message;
        }
        return $body;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($message)
    {
        $this->message = $message;
    }
}