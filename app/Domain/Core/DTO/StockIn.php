<?php

namespace App\Domain\Core\DTO;

use DateTimeInterface;

final readonly class StockIn
{
    public function __construct(
        public int $productId,
        public int $warehouseId,
        public string $qty,           // string decimal for exact math
        public string $unitCost,      // string decimal
        public string $sourceType,    // 'goods_receipt'
        public int $sourceId,
        public DateTimeInterface $occurredAt,
        public int $createdBy,
    ) {}
}
