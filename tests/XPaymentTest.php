<?php

namespace XPaymen\Tests;

use PHPUnit\Framework\TestCase;
use XPaymen\Classes\XPaymenApiService;
use XPaymen\DTOs\CryptoTransactionDTO;
use XPaymen\DTOs\CryptoTransactionReceiptDTO;
use XPaymen\DTOs\CryptoWalletDTO;
use XPaymen\DTOs\PaginatedResponseDTO;

class XPaymentTest extends TestCase
{
    protected XPaymenApiService $service;

    protected function setUp(): void
    {
        $apiKey = getenv('API_KEY') ?: '';
        $this->service = new XPaymenApiService($apiKey);
    }

    public function test_create_crypto_transaction()
    {
        $otherParams = ['payer_email' => 'test@test.com'];
        $dto = $this->service->createCryptoTransaction(rand(1, 1000000000000000000), 10, 'TRX', $otherParams);

        $this->assertInstanceOf(CryptoTransactionReceiptDTO::class, $dto);
        $keys = $dto->toArray();
        foreach (['transaction_id', 'invoice_url', 'type', 'source_amount', 'source_currency_code', 'created_at', 'created_at_timestamp'] as $key) {
            $this->assertArrayHasKey($key, $keys);
        }
    }

    public function test_get_crypto_transactions()
    {
        $paginated = $this->service->getCryptoTransactions();
        $this->assertInstanceOf(PaginatedResponseDTO::class, $paginated);

        $arr = $paginated->toArray();
        foreach (['data', 'current_page', 'last_page', 'per_page', 'total'] as $key) {
            $this->assertArrayHasKey($key, $arr);
        }

        if (! empty($paginated->data)) {
            $item = $paginated->data[0];
            $this->assertInstanceOf(CryptoTransactionDTO::class, $item);

            $arr = $item->toArray();
            foreach (['transaction_id', 'invoice_url', 'status'] as $property) {
                $this->assertArrayHasKey($property, $arr);
            }
        }
    }

    public function test_get_crypto_transaction_detail()
    {
        $paginated = $this->service->getCryptoTransactions();
        if (empty($paginated->data)) {
            $this->markTestSkipped('No transactions available to test detail.');
        }

        $transaction = $paginated->data[0];
        $this->assertInstanceOf(CryptoTransactionDTO::class, $transaction);

        $transactionId = $transaction->toArray()['transaction_id'];
        $dto = $this->service->getCryptoTransactionDetail($transactionId);

        $this->assertInstanceOf(CryptoTransactionDTO::class, $dto);
        $keys = $dto->toArray();
        foreach (['transaction_id', 'invoice_url', 'status', 'type', 'source_amount', 'source_currency_code'] as $key) {
            $this->assertArrayHasKey($key, $keys);
        }
    }

    public function test_get_crypto_wallets()
    {
        $paginated = $this->service->getCryptoWallets();
        $this->assertInstanceOf(PaginatedResponseDTO::class, $paginated);

        $arr = $paginated->toArray();
        $this->assertArrayHasKey('data', $arr);

        if (! empty($paginated->data)) {
            $wallet = $paginated->data[0];
            $this->assertInstanceOf(CryptoWalletDTO::class, $wallet);

            $arr = $wallet->toArray();
            foreach (['crypto_currency_symbol', 'address', 'balance'] as $key) {
                $this->assertArrayHasKey($key, $arr);
            }
        }
    }
}
