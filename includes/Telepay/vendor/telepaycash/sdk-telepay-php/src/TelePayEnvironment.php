<?php
namespace TelePay;

class TelePayEnvironment
{
    private $clientSecret;

    public function __construct($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getBaseUrl()
    {
        return "https://api.telepay.cash/rest/";
    }
}