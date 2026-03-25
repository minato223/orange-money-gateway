# Intégration dans Symfony

Ce document explique comment intégrer le handler de webhook Orange Money dans une application Symfony.

## 1. Installation du package

Assurez-vous d'avoir installé le package via Composer :

```bash
composer require lamine-minato/orange-money-gateway
```

## 2. Création du Contrôleur

Pour recevoir les notifications d'Orange Money, vous devez créer un point de terminaison (endpoint) POST dans votre application.

```php
// src/Controller/PaymentWebhookController.php

namespace App\Controller;

use LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentWebhookController extends AbstractController
{
    #[Route('/payment/orange-money/notif', name: 'om_webhook', methods: ['POST'])]
    public function handle(Request $request): JsonResponse
    {
        // Récupérer le payload JSON de la requête
        $payload = $request->toArray();

        // Utiliser le Gateway pour traiter le webhook
        $webhookResponse = OrangeMoneyGateway::handleWebhook($payload);

        if ($webhookResponse->isSuccess()) {
            // Le paiement a réussi
            $transactionId = $webhookResponse->getTransactionId();
            $notifToken = $webhookResponse->getNotifToken();
            
            // TODO: Mettre à jour le statut de votre commande en "Payée"
            // Exemple : $order = $this->orderRepository->findOneBy(['notifToken' => $notifToken]);
        } elseif ($webhookResponse->isFailed()) {
            // Le paiement a échoué
            // TODO: Mettre à jour le statut de votre commande en "Échouée"
        }

        // Il est important de renvoyer une réponse JSON à Orange Money
        return new JsonResponse(['status' => 'ok']);
    }
}
```

## 3. Pattern Avancé : Utilisation d'un Service dédié

Dans une application Symfony de production, il est préférable de séparer la logique de traitement du contrôleur. Vous pouvez créer un service qui implémente une interface de handler de paiement.

Voici un exemple basé sur la structure recommandée :

```php
// src/Service/Payment/OrangeMoneyWebhookHandler.php

namespace App\Service\Payment;

use LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyGateway;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrangeMoneyWebhookHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        // Injectez vos dépôts ou services ici (ex: OrderRepository)
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->toArray();
        $webhookResponse = OrangeMoneyGateway::handleWebhook($payload);

        $notifToken = $webhookResponse->getNotifToken();
        $transactionId = $webhookResponse->getTransactionId();

        if ($webhookResponse->isSuccess()) {
            // Logique de succès : marquer la commande comme payée
            // $this->markOrderAsPaid($notifToken, $transactionId);
        } elseif ($webhookResponse->isFailed()) {
            // Logique d'échec
        }

        return new JsonResponse(['status' => 'ok']);
    }
}
```

## 4. Configuration de la sécurité

Si vous utilisez Symfony Security, assurez-vous que cette route est accessible publiquement.

```yaml
# config/packages/security.yaml
security:
    access_control:
        - { path: ^/payment/orange-money/notif, roles: PUBLIC_ACCESS }
```

## 5. Utilisation du Handler comme Service

Le package fournit `LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyWebhookHandler` que vous pouvez injecter directement si besoin.

```yaml
# config/services.yaml
services:
    LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyWebhookHandler: ~
```
