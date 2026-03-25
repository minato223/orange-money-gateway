
# Orange Money Payment Gateway

A PHP package to manage payments via Orange Money in your PHP applications.

## How it work ?
* Use following command to install:
```bash
composer require lamine-minato/orange-money-gateway
```
* Create an OrangeMoneyAction object:
```php
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
```
Make sure to replace variable by the corrects one
* Call execute method on OrangeMoneyGateway class:
```php
$response = OrangeMoneyGateway::execute($action);
```
and Voila!

It will return a OrangeMoneyPaymentResponse object containing payToken and paymentUrl

In case of error, it will throw an exception of type OrangeMoneyException

You can also pass a configuration to the execute method of OrangeMoneyGateway if you want to modify the urls for retrieving the payment url

```php
$action = new OrangeMoneyAction(...);

$config = new OrangeMoneyConfig(
    tokenUrl: "https://api.orange.com/oauth/v3/token",
    proccessUrl: "https://api.orange.com/orange-money-webpay/ml/v1/webpayment",
)

```php
$response = OrangeMoneyGateway::execute($action, $config);
```

### Handling Webhooks (Notifications)

When a payment is processed, Orange Money sends a notification to your `notifUrl`. You can use the `handleWebhook` method to process this notification.

```php
#[Route('/payment/notif', name: 'payment_notification', methods: ['POST'])]
public function paymentNotification(Request $request): JsonResponse
{
    $payload = $request->toArray();
    $webhookResponse = OrangeMoneyGateway::handleWebhook($payload);

    if ($webhookResponse->isSuccess()) {
        // Update your order status to PAID
        // $webhookResponse->getNotifToken()
        // $webhookResponse->getTransactionId()
    } elseif ($webhookResponse->isFailed()) {
        // Update your order status to FAILED
    }

    return new JsonResponse(['status' => 'ok']);
}
```

> [!TIP]
> Pour une intégration plus détaillée dans Symfony (services, sécurité, etc.), consultez le [Guide d'intégration Symfony](docs/symfony_integration.md).

```php
$json = file_get_contents('php://input');
$payload = json_decode($json, true);

$webhookResponse = OrangeMoneyGateway::handleWebhook($payload);

if ($webhookResponse->isSuccess()) {
    // Success logic
}
```

> [!TIP]
> Pour une intégration plus détaillée en PHP pur (autoload, script complet, etc.), consultez le [Guide d'intégration Pure PHP](docs/pure_php_integration.md).

## License

The MIT License (MIT). Please see [License](https://github.com/minato223/orange-money-gateway/blob/master/LICENSE) for more information.

## Contributing

Read [here](https://github.com/minato223/orange-money-gateway/blob/master/CONTRIBUTING.md) for more information.