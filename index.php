<?php

use Lamine\OrangeMoneyGateway\Application\OrangeMoneyGateway;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyAction;
use Lamine\OrangeMoneyGateway\Domain\Entity\OrangeMoneyCurrency;

require __DIR__.'/vendor/autoload.php';

$action = new OrangeMoneyAction(
    orangeBearer: "bearer",
    merchantKey: "merchantKey",
    currency: OrangeMoneyCurrency::XOF,
    amount: 10000,
    returnUrl: "https://api.example.com/return",
    cancelUrl: "https://api.example.com/cancel",
    notifUrl: "https://api.example.com/notif",
    lang: "fr",
    reference: "Minato"
);
$response = OrangeMoneyGateway::execute($action);
dump($response);
?>