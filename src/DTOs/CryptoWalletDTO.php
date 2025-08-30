<?php

namespace XPaymen\DTOs;

readonly class CryptoWalletDTO
{
    public function __construct(
        public string $crypto_currency_symbol,
        public string $address,
        public string $balance,
        public string $pending_incoming_balance,
        public string $pending_outgoing_balance,
        public ?string $last_sync_attempted_at,
        public ?int $last_sync_attempted_at_timestamp,
    ) {}

    public function toArray(): array
    {
        return [
            'crypto_currency_symbol' => $this->crypto_currency_symbol,
            'address' => $this->address,
            'balance' => $this->balance,
            'pending_incoming_balance' => $this->pending_incoming_balance,
            'pending_outgoing_balance' => $this->pending_outgoing_balance,
            'last_sync_attempted_at' => $this->last_sync_attempted_at,
            'last_sync_attempted_at_timestamp' => $this->last_sync_attempted_at_timestamp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            crypto_currency_symbol: $data['crypto_currency_symbol'],
            address: $data['address'],
            balance: $data['balance'],
            pending_incoming_balance: $data['pending_incoming_balance'],
            pending_outgoing_balance: $data['pending_outgoing_balance'],
            last_sync_attempted_at: $data['last_sync_attempted_at'] ?? null,
            last_sync_attempted_at_timestamp: $data['last_sync_attempted_at_timestamp'] ?? null,
        );
    }
}
