<?php

namespace XPaymen\DTOs;

readonly class PaginatedResponseDTO
{
    public function __construct(
        public array $data,
        public int $current_page,
        public int $last_page,
        public int $per_page,
        public int $total,
    ) {}

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'current_page' => $this->current_page,
            'last_page' => $this->last_page,
            'per_page' => $this->per_page,
            'total' => $this->total,
        ];
    }
}
