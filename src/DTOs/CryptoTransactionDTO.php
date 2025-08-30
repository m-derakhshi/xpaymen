<?php

namespace XPaymen\DTOs;

readonly class CryptoTransactionDTO
{
    public function __construct(
        public string $type,
        public string $status,
        public string $invoice_url,
        public string $transaction_id,
        public float $source_amount,
        public string $source_currency_code,
        public ?string $order_id,
        public ?string $payer_email,
        public ?string $payer_message,
        public ?string $crypto_currency_symbol,
        public ?string $virtual_wallet_address,
        public ?float $virtual_wallet_pending_incoming_balance,
        public ?float $blockchain_expected_payment_amount,
        public ?float $blockchain_payment_amount,
        public ?float $blockchain_unpaid_amount,
        public ?string $confirm_at,
        public ?int $confirm_at_timestamp,
        public string $expired_at,
        public int $expired_at_timestamp,
        public string $created_at,
        public int $created_at_timestamp,
        public bool $is_callback_url_verified,
    ) {}

    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transaction_id,
            'order_id' => $this->order_id,
            'type' => $this->type,
            'source_amount' => $this->source_amount,
            'source_currency_code' => $this->source_currency_code,
            'payer_email' => $this->payer_email,
            'payer_message' => $this->payer_message,
            'crypto_currency_symbol' => $this->crypto_currency_symbol,
            'virtual_wallet_address' => $this->virtual_wallet_address,
            'virtual_wallet_pending_incoming_balance' => $this->virtual_wallet_pending_incoming_balance,
            'blockchain_expected_payment_amount' => $this->blockchain_expected_payment_amount,
            'blockchain_payment_amount' => $this->blockchain_payment_amount,
            'blockchain_unpaid_amount' => $this->blockchain_unpaid_amount,
            'status' => $this->status,
            'invoice_url' => $this->invoice_url,
            'expired_at' => $this->expired_at,
            'expired_at_timestamp' => $this->expired_at_timestamp,
            'created_at' => $this->created_at,
            'created_at_timestamp' => $this->created_at_timestamp,
            'confirm_at' => $this->confirm_at,
            'confirm_at_timestamp' => $this->confirm_at_timestamp,
            'is_callback_url_verified' => $this->is_callback_url_verified,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            status: $data['status'],
            invoice_url: $data['invoice_url'],
            transaction_id: $data['transaction_id'],
            source_amount: (float) $data['source_amount'],
            source_currency_code: $data['source_currency_code'],
            order_id: $data['order_id'] ?? null,
            payer_email: $data['payer_email'] ?? null,
            payer_message: $data['payer_message'] ?? null,
            crypto_currency_symbol: $data['crypto_currency_symbol'],
            virtual_wallet_address: $data['virtual_wallet_address'],
            virtual_wallet_pending_incoming_balance: (float) $data['virtual_wallet_pending_incoming_balance'],
            blockchain_expected_payment_amount: (float) $data['blockchain_expected_payment_amount'],
            blockchain_payment_amount: (float) $data['blockchain_payment_amount'],
            blockchain_unpaid_amount: (float) $data['blockchain_unpaid_amount'],
            confirm_at: $data['confirm_at'] ?? null,
            confirm_at_timestamp: isset($data['confirm_at_timestamp']) ? (int) $data['confirm_at_timestamp'] : null,
            expired_at: $data['expired_at'],
            expired_at_timestamp: (int) $data['expired_at_timestamp'],
            created_at: $data['created_at'],
            created_at_timestamp: (int) $data['created_at_timestamp'],
            is_callback_url_verified: (bool) $data['is_callback_url_verified'],
        );
    }
}
