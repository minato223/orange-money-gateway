<?php

namespace LamineMinato\OrangeMoneyGateway\Application;

use LamineMinato\OrangeMoneyGateway\Domain\Entity\OrangeMoneyWebhookResponse;
use LamineMinato\OrangeMoneyGateway\Domain\OrangeMoneyWebhookHandlerInterface;

class OrangeMoneyWebhookHandler implements OrangeMoneyWebhookHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(array $payload): OrangeMoneyWebhookResponse
    {
        $status = $payload['status'] ?? 'unknown';
        $notifToken = $payload['notif_token'] ?? null;
        $transactionId = $payload['txnid'] ?? $payload['transaction_id'] ?? null;

        return new OrangeMoneyWebhookResponse(
            (string) $status,
            $notifToken ? (string) $notifToken : null,
            $transactionId ? (string) $transactionId : null,
            $payload
        );
    }
}
