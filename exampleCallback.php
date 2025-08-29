<?php

use XPaymen\Classes\XPaymenApiService;
use XPaymen\DTOs\CryptoTransactionDTO;

require 'vendor/autoload.php';

$apiKey = 'XPI2NzrwM1y7YmenQu6BcdgLlbXLEaNCrZnkw3svgAdsNnWMsYq61ZgsxGL1CMx1';

$service = new XPaymenApiService($apiKey);

$verifiedTransaction = $service->verifyCallbackData();
if ($verifiedTransaction instanceof CryptoTransactionDTO) {

    // Optional: verifies the transaction on XPaymen.com and can be used to record callback confirmation
    $service->verifyCryptoTransactionInSite($verifiedTransaction->transactionId);

    print_r($verifiedTransaction->toArray());
} else {
    echo 'Callback verification failed.';
}
