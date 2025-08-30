# XPaymen PHP API Client

A PHP client library for interacting with the [XPaymen](https://xpaymen.com) cryptocurrency payment gateway API.  
This library makes it easy to create and manage crypto transactions, wallets, and verify callback data.

## Table of Contents

* [Installation](#installation)
* [Configuration](#configuration)
* [Obtaining an API Key](#obtaining-an-api-key)
* [Usage](#usage)
    * [Create a Crypto Transaction](#create-a-crypto-transaction)
    * [Get Crypto Transactions](#get-crypto-transactions)
    * [Get Transaction Detail](#get-transaction-detail)
    * [Get Crypto Wallets](#get-crypto-wallets)
    * [Verify Callback Data](#verify-callback-data)
* [Testing](#testing)
* [License](#license)

## Installation

Install this package via Composer:

```bash
composer require m-derakhshi/xpaymen
```

## Configuration

Set your **API key** in your environment or pass it directly to the client:

```php
use XPaymen\Classes\XPaymenApiService;

$apiKey = getenv('API_KEY'); // or set directly
$service = new XPaymenApiService($apiKey);
```

## Obtaining an API Key

To obtain an API key, visit the official [XPaymen website](https://xpaymen.com).  
Once registered, you can create and manage crypto payment gateways, and retrieve your API key from the **gateway details page**.

## Usage

### Create a Crypto Transaction

```php
$orderId = '1234';
$sourceAmount = 10;
$sourceCurrencyCode = 'USD';

$transaction = $service->createCryptoTransaction($orderId, $sourceAmount, $sourceCurrencyCode, [
    'payer_email' => 'user@example.com',
    'payer_message' => 'hi!',
]);

echo $transaction->transaction_id;
echo $transaction->invoice_url;
```

### Get Crypto Transactions

```php
$paginated = $service->getCryptoTransactions();

foreach ($paginated->data as $transaction) {
    echo $transaction->transaction_id;
    echo $transaction->status;
}
```

### Get Transaction Detail

```php
$transaction = $service->getCryptoTransactionDetail('TX123456');

echo $transaction->status;
echo $transaction->invoice_url;
```

### Get Crypto Wallets

```php
$wallets = $service->getCryptoWallets();

foreach ($wallets->data as $wallet) {
    echo $wallet->crypto_currency_symbol;
    echo $wallet->balance;
}
```

### Verify Callback Data

To handle payment callbacks, you need to create a dedicated file or route in your website (for example: `callback.php`).

Place this file on your server and then configure its URL in your **Crypto Payment Gateway settings** on [XPaymen.com](https://xpaymen.com).

For example:

```
https://example.com/callback.php
```

**Example `callback.php`:**

```php
<?php

use XPaymen\Classes\XPaymenApiService;
use XPaymen\DTOs\CryptoTransactionDTO;

require 'vendor/autoload.php';

$apiKey = 'XPI2NzrwM1y7YmenQu6BcdgLlbXLEaNCrZnkw3svgAdsNnWMsYq61ZgsxGL1CMx1';
$service = new XPaymenApiService($apiKey);

echo '<pre>';
try {
    $verifiedTransaction = $service->verifyCallbackData();

    if ($verifiedTransaction instanceof CryptoTransactionDTO) {
        echo "✅ Callback verified transaction:\n";
        print_r($verifiedTransaction->toArray());

        // Optional: Verify transaction on XPaymen.com
        try {
            $callbackTransaction = $service->verifyCryptoTransactionInSite($verifiedTransaction->transactionId);

            if ($callbackTransaction->isCallbackUrlVerified) {
                echo "\n✅ Callback URL is verified.\n";
            } else {
                echo "\n⚠ Callback URL not verified.\n";
            }

        } catch (Throwable $e) {
            echo "\n❌ Error verifying transaction on site: ".$e->getMessage()."\n";
        }

    } else {
        echo "⚠ Callback verification failed.\n";
    }

} catch (Throwable $e) {
    echo '❌ Error verifying callback data: '.$e->getMessage()."\n";
}
echo '</pre>';
```

## Testing

This repository includes PHPUnit tests.  
You can run the tests with your API key in a single command:

```bash
API_KEY="your_api_key_here" vendor/bin/phpunit
```

## License

This project is licensed under the MIT License.