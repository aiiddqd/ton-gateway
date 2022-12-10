<?php

namespace Test;

use TelePay\TelePayClient;
use TelePay\TelePayEnvironment;

class TestInit
{
    public static function client()
    {
        return new TelePayClient(self::environment());
    }
    public static function environment()
    {
        $clientSecret = getenv("TELEPAY_SECRET")  ?: "TELEPAY_SECRET";
        return new TelePayEnvironment($clientSecret);
    }
}
