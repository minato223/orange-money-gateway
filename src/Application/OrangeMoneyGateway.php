<?php

namespace LamineMinato\OrangeMoneyGateway\Application;

use LamineMinato\OrangeMoneyGateway\Domain\Constant\OrangeMoneyConstant;
use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyAction;
use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyConfig;
use LamineMinato\OrangeMoneyGateway\Domain\Exception\OrangeMoneyException;
use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyPaymentResponse;
use LamineMinato\OrangeMoneyGateway\Domain\OrangeMoneyGatewayInterface;
use LamineMinato\OrangeMoneyGateway\Infrastructure\OrangeMoney\OrangeMoneyHttpClient;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class OrangeMoneyGateway implements OrangeMoneyGatewayInterface
{
    public static function execute(OrangeMoneyAction $action, ?OrangeMoneyConfig $config = null): OrangeMoneyPaymentResponse
    {
        $accessor = new PropertyAccessor();
        if (null == $config) {
            $config = OrangeMoneyConstant::defaultConfig();
        }
        $response = OrangeMoneyHttpClient::post($config->getTokenUrl(), [
            'body' => array('grant_type' => 'client_credentials'),
            "headers" => [
                "Authorization: Basic " . $action->getOrangeBearer(),
                'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
            ]
        ]);
        $bearerResponse = json_decode($response->getContent(false), true);
        if ($response->getStatusCode() !== OrangeMoneyConstant::HTTP_OK) {
            $error = $accessor->getValue($bearerResponse, '[error]');
            $error_description = $accessor->getValue($bearerResponse, '[error_description]');
            throw new OrangeMoneyException($error, $error_description);
        }
        $response = OrangeMoneyHttpClient::post($config->getProccessUrl(), [
            'body' => json_encode($action->getPayload()),
            "headers" => [
                sprintf("Authorization: %s %s", $bearerResponse['token_type'], $bearerResponse['access_token']),
                "Content-Type: application/json"
            ]
        ]);
        $urlResponse = json_decode($response->getContent(false), true);
        if ($response->getStatusCode() !== OrangeMoneyConstant::HTTP_CREATED) {
            $message = $accessor->getValue($urlResponse, '[message]');
            $description = $accessor->getValue($urlResponse, '[description]');
            throw new OrangeMoneyException($message, $description);
        }
        return new OrangeMoneyPaymentResponse($urlResponse['notif_token'], $urlResponse['payment_url']);
    }
}
