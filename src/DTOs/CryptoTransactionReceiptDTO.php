<?php

namespace XPaymen\DTOs;

readonly class CryptoTransactionReceiptDTO
{
    public function __construct(
        public string $type,
        public string $invoice_url,
        public string $transaction_id,
        public string $source_amount,
        public string $source_currency_code,
        public ?string $order_id,
        public ?string $payer_email,
        public ?string $payer_message,
        public string $created_at,
        public int $created_at_timestamp,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'invoice_url' => $this->invoice_url,
            'transaction_id' => $this->transaction_id,
            'source_amount' => $this->source_amount,
            'source_currency_code' => $this->source_currency_code,
            'order_id' => $this->order_id,
            'payer_email' => $this->payer_email,
            'payer_message' => $this->payer_message,
            'created_at' => $this->created_at,
            'created_at_timestamp' => $this->created_at_timestamp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            invoice_url: $data['invoice_url'],
            transaction_id: $data['transaction_id'],
            source_amount: $data['source_amount'],
            source_currency_code: $data['source_currency_code'],
            order_id: $data['order_id'] ?? null,
            payer_email: $data['payer_email'] ?? null,
            payer_message: $data['payer_message'] ?? null,
            created_at: $data['created_at'],
            created_at_timestamp: (int) $data['created_at_timestamp'],
        );
    }
}
