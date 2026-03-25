# Intégration en PHP Pure (sans framework)

Ce document explique comment intégrer le handler de webhook Orange Money dans un script PHP classique.

## 1. Installation

Assurez-vous d'avoir installé le package via Composer et d'inclure l'autoloader dans votre script :

```php
require_once __DIR__ . '/vendor/autoload.php';

use LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyGateway;
```

## 2. Création du script de Webhook (`webhook.php`)

Pour recevoir les notifications d'Orange Money, créez un fichier PHP accessible publiquement via une URL (ex: `https://votre-domaine.com/webhook.php`).

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use LamineMinato\OrangeMoneyGateway\Application\OrangeMoneyGateway;

// 1. Récupérer le contenu brut de la requête POST
$json = file_get_contents('php://input');

// 2. Décoder le JSON
$payload = json_decode($json, true);

if (!$payload) {
    http_response_code(400);
    exit('Invalid payload');
}

// 3. Traiter le webhook via le Gateway
try {
    $webhookResponse = OrangeMoneyGateway::handleWebhook($payload);

    if ($webhookResponse->isSuccess()) {
        $transactionId = $webhookResponse->getTransactionId();
        $notifToken = $webhookResponse->getNotifToken();

        // TODO: Mettre à jour votre base de données
        // Exemple : $pdo->prepare("UPDATE orders SET status = 'paid', tx_id = ? WHERE notif_token = ?");
        
    } elseif ($webhookResponse->isFailed()) {
        // Le paiement a échoué
    }

    // 4. Répondre à Orange Money
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
```

## 3. Remarques importantes

- **Sécurité** : Orange Money envoie les notifications depuis ses serveurs. Contrairement à Symfony, vous devez gérer manuellement l'accès si vous souhaitez restreindre par IP (bien que le `notif_token` serve déjà de vérification d'identité pour la transaction).
- **Logs** : Il est fortement recommandé de logger les payloads reçus pour faciliter le débogage :
  ```php
  file_put_contents('webhooks.log', $json . PHP_EOL, FILE_APPEND);
  ```
