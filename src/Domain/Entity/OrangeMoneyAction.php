<?php

namespace Lamine\OrangeMoneyGateway\Domain\Entity;

class OrangeMoneyAction
{
    /** 
     * 
     * @param string|null $orangeBearer 
     * @param string|null $merchantKey 
     * @param string|null $currency 
     * @param string|null $orderId 
     * @param string|null $amount 
     * @param string|null $returnUrl 
     * @param string|null $cancelUrl 
     * @param string|null $notifUrl 
     * @param string|null $lang 
     * @param string|null $reference 
     */
    public function __construct(
        private ?string $orangeBearer = null,
        private ?string $merchantKey = null,
        private ?string $currency = null,
        private ?string $orderId = null,
        private ?float $amount = null,
        private ?string $returnUrl = null,
        private ?string $cancelUrl = null,
        private ?string $notifUrl = null,
        private ?string $lang = null,
        private ?string $reference = null
    ) {
    }

    public function getOrangeBearer()
    {
        return $this->orangeBearer;
    }

    public function getPayload(): array
    {
        return [
            "merchant_key" => $this->merchantKey,
            "currency" => $this->currency,
            "order_id" => $this->orderId ?? uniqid(),
            "amount" => $this->amount,
            "return_url" => $this->returnUrl,
            "cancel_url" => $this->cancelUrl,
            "notif_url" => $this->notifUrl,
            "lang" => $this->lang,
            "reference" => $this->reference
        ];
    }
}
