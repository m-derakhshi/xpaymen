<?php

use XPaymen\Classes\XPaymenApiService;
use XPaymen\DTOs\CryptoTransactionDTO;

require 'vendor/autoload.php';

$apiKey = 'XPI2NzrwM1y7YmenQu6BcdgLlbXLEaNCrZnkw3svgAdsNnWMsYq61ZgsxGL1CMx1';

$service = new XPaymenApiService($apiKey);

$verifiedTransactionDTO = $service->verifyCallbackData();
if ($verifiedTransactionDTO instanceof CryptoTransactionDTO) {

    // Optional: verifies the transaction on XPaymen.com and can be used to record callback confirmation
    $service->verifyCryptoTransactionInSite($verifiedTransactionDTO->transactionId);

    print_r($verifiedTransactionDTO->toArray());
} else {
    echo 'Callback verification failed.';
}
