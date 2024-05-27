<?php

namespace Lamine\OrangeMoneyGateway\Application;

use Lamine\OrangeMoneyGateway\Domain\Constant\OrangeMoneyConstant;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyAction;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyConfig;
use Lamine\OrangeMoneyGateway\Domain\Exception\OrangeMoneyException;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyPaymentResponse;
use Lamine\OrangeMoneyGateway\Domain\OrangeMoneyGatewayInterface;
use Lamine\OrangeMoneyGateway\Infrastructure\OrangeMoney\OrangeMoneyHttpClient;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class OrangeMoneyGateway implements OrangeMoneyGatewayInterface
{
    public static function execute(OrangeMoneyAction $action, ?OrangeMoneyConfig $config = null): OrangeMoneyPaymentResponse
    {
        try {
            $accessor = new PropertyAccessor();
            if (null == $config) {
                $config = OrangeMoneyConstant::defaultConfig();
            }
            $response = OrangeMoneyHttpClient::post($config->getTokenUrl(), [
                'body'=>array('grant_type' => 'client_credentials'),
                "headers"=>[
                    "Authorization: Basic " . $action->getOrangeBearer(),
                    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                ]
            ]);
            $bearerResponse = json_decode($response->getContent(false), true);
            if ($response->getStatusCode()!==OrangeMoneyConstant::HTTP_OK) {
                $error = $accessor->getValue($bearerResponse, '[error]');
                $error_description = $accessor->getValue($bearerResponse, '[error_description]');
                throw new OrangeMoneyException($error, $error_description);
            }
            $response = OrangeMoneyHttpClient::post($config->getProccessUrl(), [
                'body'=>json_encode($action->getPayload()),
                "headers"=>[
                    sprintf("Authorization: %s %s", $bearerResponse['token_type'], $bearerResponse['access_token']),
                    "Content-Type: application/json"
                ]
            ]);
            $urlResponse = json_decode($response->getContent(false), true);
            if ($response->getStatusCode()!==OrangeMoneyConstant::HTTP_CREATED) {
                $message = $accessor->getValue($urlResponse, '[message]');
                $description = $accessor->getValue($urlResponse, '[description]');
                throw new OrangeMoneyException($message, $description);
            }
            return new OrangeMoneyPaymentResponse($urlResponse['pay_token'], $urlResponse['payment_url']);
        } catch (\Throwable $th) {
            throw new OrangeMoneyException($th->getMessage());
        }
    }
}
