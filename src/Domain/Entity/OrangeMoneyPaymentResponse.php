<?php

namespace LamineMinato\OrangeMoneyGateway\Domain\Entity;

class OrangeMoneyPaymentResponse
{
    public function __construct(private ?string $paymentToken = null, private ?string $paymentLink = null)
    {
    }
    public function getPaymentLink()
    {
        return $this->paymentLink;
    }
    public function getPaymentToken()
    {
        return $this->paymentToken;
    }
}
