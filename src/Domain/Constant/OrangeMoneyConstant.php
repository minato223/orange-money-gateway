<?php

namespace Lamine\OrangeMoneyGateway\Domain\Constant;

use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyConfig;

class OrangeMoneyConstant
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;

    public const TOKEN_URL = "https://api.orange.com/oauth/v3/token";
    public const PROCCESS_URL = "https://api.orange.com/orange-money-webpay/ml/v1/webpayment";
    public static function defaultConfig() : OrangeMoneyConfig {
        $config = new OrangeMoneyConfig(self::TOKEN_URL, self::PROCCESS_URL);
        return $config;
    }
}
