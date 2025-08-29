<?php

namespace XPaymen\DTOs;

readonly class CryptoWalletDTO
{
    public function __construct(
        public string $cryptoCurrencySymbol,
        public string $address,
        public string $balance,
        public string $pendingIncomingBalance,
        public string $pendingOutgoingBalance,
        public ?string $lastSyncAttemptedAt,
        public ?int $lastSyncAttemptedAtTimestamp,
    ) {}

    public function toArray(): array
    {
        return [
            'crypto_currency_symbol' => $this->cryptoCurrencySymbol,
            'address' => $this->address,
            'balance' => $this->balance,
            'pending_incoming_balance' => $this->pendingIncomingBalance,
            'pending_outgoing_balance' => $this->pendingOutgoingBalance,
            'last_sync_attempted_at' => $this->lastSyncAttemptedAt,
            'last_sync_attempted_at_timestamp' => $this->lastSyncAttemptedAtTimestamp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cryptoCurrencySymbol: $data['crypto_currency_symbol'],
            address: $data['address'],
            balance: $data['balance'],
            pendingIncomingBalance: $data['pending_incoming_balance'],
            pendingOutgoingBalance: $data['pending_outgoing_balance'],
            lastSyncAttemptedAt: $data['last_sync_attempted_at'] ?? null,
            lastSyncAttemptedAtTimestamp: $data['last_sync_attempted_at_timestamp'] ?? null,
        );
    }
}
