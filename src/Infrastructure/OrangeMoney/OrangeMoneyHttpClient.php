<?php

namespace Lamine\OrangeMoneyGateway\Infrastructure\OrangeMoney;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OrangeMoneyHttpClient {

    public const METHOD_HEAD = 'HEAD';
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';

    /**
     * 
     * @param string $url
     * @param array $options
     */
    public static function post($url, $options) : ResponseInterface {
        $client = HttpClient::create();
        return $client->request(self::METHOD_POST, $url, $options);
    }
}