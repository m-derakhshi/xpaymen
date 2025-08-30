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
            $callbackTransaction = $service->verifyCryptoTransactionInSite($verifiedTransaction->transaction_id);

            if ($callbackTransaction->is_callback_url_verified) {
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
