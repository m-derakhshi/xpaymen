<?php

namespace XPaymen\DTOs;

readonly class PaginatedResponseDTO
{
    public function __construct(
        public array $data,
        public int $currentPage,
        public int $lastPage,
        public int $perPage,
        public int $total,
    ) {}

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
        ];
    }
}
