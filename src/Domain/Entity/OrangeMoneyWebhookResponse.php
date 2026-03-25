<?php

namespace LamineMinato\OrangeMoneyGateway\Domain\Entity;

class OrangeMoneyWebhookResponse
{
    private string $status;
    private ?string $notifToken;
    private ?string $transactionId;
    private array $rawPayload;

    public function __construct(string $status, ?string $notifToken, ?string $transactionId, array $rawPayload)
    {
        $this->status = $status;
        $this->notifToken = $notifToken;
        $this->transactionId = $transactionId;
        $this->rawPayload = $rawPayload;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getNotifToken(): ?string
    {
        return $this->notifToken;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getRawPayload(): array
    {
        return $this->rawPayload;
    }

    public function isSuccess(): bool
    {
        return in_array(strtoupper($this->status), ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'], true);
    }

    public function isFailed(): bool
    {
        return in_array(strtoupper($this->status), ['FAILED', 'ERROR', 'CANCELLED', 'EXPIRED'], true);
    }
}
