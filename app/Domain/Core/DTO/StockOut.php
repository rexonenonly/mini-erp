<?php

namespace App\Domain\Core\DTO;

use DateTimeInterface;

final readonly class StockOut
{
    public function __construct(
        public int $productId,
        public int $warehouseId,
        public string $qty,           // string decimal for exact math
        public string $sourceType,    // 'delivery'
        public int $sourceId,
        public DateTimeInterface $occurredAt,
        public int $createdBy,
    ) {}
}
