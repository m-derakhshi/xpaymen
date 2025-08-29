<?php

namespace XPaymen\DTOs;

readonly class CryptoTransactionDTO
{
    public function __construct(
        public string $type,
        public string $status,
        public string $invoiceUrl,
        public string $transactionId,
        public string $sourceAmount,
        public string $sourceCurrencyCode,
        public ?string $orderId,
        public ?string $payerEmail,
        public ?string $payerMessage,
        public ?string $cryptoCurrencySymbol,
        public ?string $virtualWalletAddress,
        public ?float $virtualWalletPendingIncomingBalance,
        public ?string $blockchainExpectedPaymentAmount,
        public ?string $blockchainPaymentAmount,
        public ?string $blockchainUnpaidAmount,
        public ?string $confirmAt,
        public ?int $confirmAtTimestamp,
        public string $expiredAt,
        public int $expiredAtTimestamp,
        public string $createdAt,
        public int $createdAtTimestamp,
        public bool $isCallbackUrlVerified,
    ) {}

    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'order_id' => $this->orderId,
            'type' => $this->type,
            'source_amount' => $this->sourceAmount,
            'source_currency_code' => $this->sourceCurrencyCode,
            'payer_email' => $this->payerEmail,
            'payer_message' => $this->payerMessage,
            'crypto_currency_symbol' => $this->cryptoCurrencySymbol,
            'virtual_wallet_address' => $this->virtualWalletAddress,
            'virtual_wallet_pending_incoming_balance' => $this->virtualWalletPendingIncomingBalance,
            'blockchain_expected_payment_amount' => $this->blockchainExpectedPaymentAmount,
            'blockchain_payment_amount' => $this->blockchainPaymentAmount,
            'blockchain_unpaid_amount' => $this->blockchainUnpaidAmount,
            'status' => $this->status,
            'invoice_url' => $this->invoiceUrl,
            'expired_at' => $this->expiredAt,
            'expired_at_timestamp' => $this->expiredAtTimestamp,
            'created_at' => $this->createdAt,
            'created_at_timestamp' => $this->createdAtTimestamp,
            'confirm_at' => $this->confirmAt,
            'confirm_at_timestamp' => $this->confirmAtTimestamp,
            'is_callback_url_verified' => $this->isCallbackUrlVerified,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            status: $data['status'],
            invoiceUrl: $data['invoice_url'],
            transactionId: $data['transaction_id'],
            sourceAmount: $data['source_amount'],
            sourceCurrencyCode: $data['source_currency_code'],
            orderId: $data['order_id'] ?? null,
            payerEmail: $data['payer_email'] ?? null,
            payerMessage: $data['payer_message'] ?? null,
            cryptoCurrencySymbol: $data['crypto_currency_symbol'],
            virtualWalletAddress: $data['virtual_wallet_address'],
            virtualWalletPendingIncomingBalance: (float) $data['virtual_wallet_pending_incoming_balance'],
            blockchainExpectedPaymentAmount: $data['blockchain_expected_payment_amount'],
            blockchainPaymentAmount: $data['blockchain_payment_amount'],
            blockchainUnpaidAmount: $data['blockchain_unpaid_amount'],
            confirmAt: $data['confirm_at'] ?? null,
            confirmAtTimestamp: isset($data['confirm_at_timestamp']) ? (int) $data['confirm_at_timestamp'] : null,
            expiredAt: $data['expired_at'],
            expiredAtTimestamp: (int) $data['expired_at_timestamp'],
            createdAt: $data['created_at'],
            createdAtTimestamp: (int) $data['created_at_timestamp'],
            isCallbackUrlVerified: (bool) $data['is_callback_url_verified'],
        );
    }
}
