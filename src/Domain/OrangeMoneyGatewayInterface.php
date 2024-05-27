<?php

namespace LamineMinato\OrangeMoneyGateway\Domain;

use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyAction;
use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyConfig;
use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyPaymentResponse;

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
