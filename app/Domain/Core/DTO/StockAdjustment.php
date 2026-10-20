<?php

namespace App\Domain\Core\DTO;

use DateTimeInterface;

final readonly class StockAdjustment
{
    public function __construct(
        public int $productId,
        public int $warehouseId,
        public string $qtySystem,     // snapshot at count time
        public string $qtyCounted,    // physical count
        public string $unitCost,      // required if adding stock when qty was 0
        public string $sourceType,    // 'stock_opname'
        public int $sourceId,
        public DateTimeInterface $occurredAt,
        public int $createdBy,
    ) {}
}
