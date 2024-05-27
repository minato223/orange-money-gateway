<?php

namespace LamineMinato\OrangeMoneyGateway\Domain\Entity;

class OrangeMoneyConfig
{

    public function __construct(
        private ?string $tokenUrl = null,
        private ?string $proccessUrl = null
    ) {
    }

    public function getTokenUrl()
    {
        return $this->tokenUrl;
    }
    public function getProccessUrl()
    {
        return $this->proccessUrl;
    }
}
