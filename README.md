# XPaymen PHP API Client

A PHP client library for interacting with the [XPaymen](https://xpaymen.com) cryptocurrency payment gateway API. This library allows you to create and manage crypto transactions, wallets, and verify callback data easily.

## Table of Contents

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)

    * [Create a Crypto Transaction](#create-a-crypto-transaction)
    * [Get Crypto Transactions](#get-crypto-transactions)
    * [Get Transaction Detail](#get-transaction-detail)
    * [Get Crypto Wallets](#get-crypto-wallets)
    * [Verify Callback Data](#verify-callback-data)
* [Testing](#testing)
* [Obtaining an API Key](#obtaining-an-api-key)
* [License](#license)

## Installation

You can install this package via Composer:

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

To get your API key, visit the official XPaymen website:

[https://xpaymen.com](https://xpaymen.com)

After signing up, you can create and manage your API keys in your crypto payment gateway details.


## Usage

### Create a Crypto Transaction

```php
$orderId = '1234';
$sourceAmount = 10;
$sourceCurrencyCode = 'USD';
$transaction = $service->createCryptoTransaction($orderId,$sourceAmount,$sourceCurrencyCode,[
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

### Verify Callback Data File

```php
<?php
use XPaymen\Classes\XPaymenApiService;
use XPaymen\DTOs\CryptoTransactionDTO;

require 'vendor/autoload.php';

$service = new XPaymenApiService('api key');

$verifiedTransactionDTO = $service->verifyCallbackData();
if ($verifiedTransactionDTO instanceof CryptoTransactionDTO) {

    // Optional: verifies the transaction on XPaymen.com and can be used to record callback confirmation
    $service->verifyCryptoTransactionInSite($verifiedTransactionDTO->transactionId);

    print_r($verifiedTransactionDTO->toArray());
} else {
    echo 'Callback verification failed.';
}
```

## Testing

The repository includes PHPUnit tests. Run the tests with:

```bash
vendor/bin/phpunit
```

Make sure to set your API key in the environment for tests:

```bash
export API_KEY="your_api_key_here"
```

## License

This project is licensed under the MIT License.