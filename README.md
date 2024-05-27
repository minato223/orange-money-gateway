
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

$response = OrangeMoneyGateway::execute($action, $config);
```

## License

The MIT License (MIT). Please see [License](https://github.com/minato223/orange-money-gateway/blob/master/LICENSE) for more information.

## Contributing

Read [here](https://github.com/minato223/orange-money-gateway/blob/master/CONTRIBUTING.md) for more information.