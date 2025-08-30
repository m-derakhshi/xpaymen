<?php

namespace XPaymen\Classes;

use XPaymen\DTOs\CryptoTransactionDTO;
use XPaymen\DTOs\CryptoTransactionReceiptDTO;
use XPaymen\DTOs\CryptoWalletDTO;
use XPaymen\DTOs\PaginatedResponseDTO;

class XPaymenApiService
{
    private string $apiKey;

    private string $apiUrl = 'https://xpaymen.com/en/api/v1';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setApiUrl(string $apiUrl): static
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    private function fetchUrl(string $url): array
    {
        $curl = curl_init();

        $defaultHeaders = [
            "X-API-Key: {$this->apiKey}",
            'Accept: application/json',
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $defaultHeaders,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => true, // برای دریافت header
        ];

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            curl_close($curl);
            throw new \RuntimeException("cURL Error: {$err}");
        }

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $body = substr($response, $headerSize);

        curl_close($curl);

        $decoded = json_decode($body, true);

        if ($decoded === null) {
            throw new \RuntimeException("Invalid JSON response from {$url}");
        }
        if ($httpCode !== 200) {
            throw new \RuntimeException($decoded['message'] ?? "HTTP Error {$httpCode} for URL: {$url} Response: {$body}");
        }
        if (! isset($decoded['data'])) {
            throw new \RuntimeException($decoded['message'] ?? "Response does not contain 'data' key from {$url}");
        }

        return $decoded['data'];
    }

    public function createCryptoTransaction(string $orderID, float $sourceAmount, string $sourceCurrencyCode, array $parameters): CryptoTransactionReceiptDTO
    {
        $parameters = [
            ...$parameters,
            'source_amount' => $sourceAmount,
            'source_currency_code' => $sourceCurrencyCode,
            'order_id' => $orderID,
        ];
        $query = http_build_query($parameters);
        $response = $this->fetchUrl($this->apiUrl."/crypto-transaction/create?{$query}");
        if (! isset($response['transaction_id'])) {
            throw new \RuntimeException($response['message'] ?? "API response does not contain 'data'");
        }

        return CryptoTransactionReceiptDTO::fromArray($response);
    }

    public function getCryptoTransactions(): PaginatedResponseDTO
    {
        $response = $this->fetchUrl($this->apiUrl.'/crypto-transactions');
        $dataItems = $response['data'] ?? [];

        $transactionsDto = array_map(fn ($item) => CryptoTransactionDTO::fromArray($item), $dataItems);

        return new PaginatedResponseDTO(
            data: $transactionsDto,
            current_page: $response['current_page'] ?? 1,
            last_page: $response['last_page'] ?? 1,
            per_page: $response['per_page'] ?? 10,
            total: $response['total'] ?? 0
        );
    }

    public function getCryptoTransactionDetail(string $transactionID): CryptoTransactionDTO
    {
        $response = $this->fetchUrl($this->apiUrl.'/crypto-transaction/'.$transactionID);

        if (! isset($response['transaction_id'])) {
            throw new \RuntimeException($response['message'] ?? "API response does not contain 'transaction_id'");
        }

        return CryptoTransactionDTO::fromArray($response);
    }

    public function verifyCallbackData(): false|CryptoTransactionDTO
    {
        if (! isset($_POST['verify_hash']) || ! isset($_POST['transaction_id'])) {
            return false;
        }
        $verifyHash = $_POST['verify_hash'];
        unset($_POST['verify_hash']);

        $filtered = [];
        foreach ($_POST as $k => $v) {
            if ($v === null) {
                $filtered[$k] = '';
            } elseif (is_bool($v) || $v === 'false' || $v === 'true') {
                $filtered[$k] = ($v === true || $v === 'true') ? '1' : '0';
            } elseif (filter_var($v, FILTER_VALIDATE_URL)) {
                $filtered[$k] = rawurldecode($v);
            } else {
                $filtered[$k] = (string) $v;
            }
        }
        ksort($filtered);
        $serialized = serialize($filtered);
        $calculatedHash = hash_hmac('sha1', $serialized, $this->apiKey);

        if (hash_equals($calculatedHash, $verifyHash)) {
            return CryptoTransactionDTO::fromArray($_POST);
        }

        return false;
    }

    public function verifyCryptoTransactionInSite(CryptoTransactionDTO $verifiedTransaction): CryptoTransactionDTO
    {
        $query = http_build_query([
            'order_id' => $verifiedTransaction->order_id,
            'source_amount' => $verifiedTransaction->source_amount,
            'source_currency_code' => $verifiedTransaction->source_currency_code,
            'crypto_currency_symbol' => $verifiedTransaction->crypto_currency_symbol,
            'blockchain_expected_payment_amount' => $verifiedTransaction->blockchain_expected_payment_amount,
            'blockchain_payment_amount' => $verifiedTransaction->blockchain_payment_amount,
        ]);
        $response = $this->fetchUrl($this->apiUrl.'/crypto-transaction/'.$verifiedTransaction->transaction_id.'/callback/verify?'.$query);

        if (! isset($response['transaction_id'])) {
            throw new \RuntimeException($response['message'] ?? "API response does not contain 'transaction_id'");
        }

        return CryptoTransactionDTO::fromArray($response);
    }

    public function getCryptoWallets(): PaginatedResponseDTO
    {
        $response = $this->fetchUrl($this->apiUrl.'/crypto-wallets');
        $dataItems = $response['data'] ?? [];

        $transactionsDto = array_map(fn ($item) => CryptoWalletDTO::fromArray($item), $dataItems);

        return new PaginatedResponseDTO(
            data: $transactionsDto,
            current_page: $response['current_page'] ?? 1,
            last_page: $response['last_page'] ?? 1,
            per_page: $response['per_page'] ?? 10,
            total: $response['total'] ?? 0
        );
    }
}
