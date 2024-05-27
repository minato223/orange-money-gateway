<?php

namespace Lamine\OrangeMoneyGateway\Domain;

use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyAction;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyConfig;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyPaymentResponse;

interface OrangeMoneyGatewayInterface
{
    /**
     * 
     * @param OrangeMoneyAction $action
     * @param OrangeMoneyConfig|null $config
     * 
     * @return OrangeMoneyPaymentResponse
     */
    public static function execute(OrangeMoneyAction $action, ?OrangeMoneyConfig $config=null): OrangeMoneyPaymentResponse;
}
