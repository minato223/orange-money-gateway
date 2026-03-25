<?php

namespace LamineMinato\OrangeMoneyGateway\Domain;

interface OrangeMoneyWebhookHandlerInterface
{
    /**
     * Handle the webhook request and return a result object.
     *
     * @param array $payload The JSON-decoded payload from Orange Money.
     * @return Entity\OrangeMoneyWebhookResponse
     */
    public function handle(array $payload): Entity\OrangeMoneyWebhookResponse;
}
