<?php

namespace XPaymen\DTOs;

readonly class CryptoTransactionReceiptDTO
{
    public function __construct(
        public string $type,
        public string $invoiceUrl,
        public string $transactionId,
        public string $sourceAmount,
        public string $sourceCurrencyCode,
        public ?string $orderId,
        public ?string $payerEmail,
        public ?string $payerMessage,
        public string $createdAt,
        public int $createdAtTimestamp,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'invoice_url' => $this->invoiceUrl,
            'transaction_id' => $this->transactionId,
            'source_amount' => $this->sourceAmount,
            'source_currency_code' => $this->sourceCurrencyCode,
            'order_id' => $this->orderId,
            'payer_email' => $this->payerEmail,
            'payer_message' => $this->payerMessage,
            'created_at' => $this->createdAt,
            'created_at_timestamp' => $this->createdAtTimestamp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            invoiceUrl: $data['invoice_url'],
            transactionId: $data['transaction_id'],
            sourceAmount: $data['source_amount'],
            sourceCurrencyCode: $data['source_currency_code'],
            orderId: $data['order_id'] ?? null,
            payerEmail: $data['payer_email'] ?? null,
            payerMessage: $data['payer_message'] ?? null,
            createdAt: $data['created_at'],
            createdAtTimestamp: (int) $data['created_at_timestamp'],
        );
    }
}
