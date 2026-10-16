<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Core\Contracts\StockLedger as StockLedgerContract;
use App\Domain\Inventory\DTO\StockAdjustment;
use App\Domain\Inventory\DTO\StockIn;
use App\Domain\Inventory\DTO\StockOut;
use App\Models\StockBalance;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Implements moving-average cost (weighted average) using bcmath for exact decimal.
 *
 * All arithmetic is string-based (bcmath) to avoid float rounding.
 * Caller is responsible for wrapping calls in DB::transaction().
 *
 * ponytail: bcmath with scale=4 for cost, scale=2 for value. Upgrade to brick/math
 *           if sub-cent precision required (e.g. fractional currency units).
 */
class StockLedger implements StockLedgerContract
{
    private const QTY_SCALE = 4;
    private const VAL_SCALE = 2;
    private const COST_SCALE = 4;

    public function receive(StockIn $dto): void
    {
        // Lock the balance row; create if first receipt
        $balance = $this->lockOrCreate($dto->productId, $dto->warehouseId);

        $qty     = $dto->qty;
        $cost    = $dto->unitCost;
        $valueIn = $this->round(bcmul($qty, $cost, 10), self::VAL_SCALE);

        $newQty   = bcadd($balance->on_hand, $qty, self::QTY_SCALE);
        $newValue = bcadd($balance->total_value, $valueIn, self::VAL_SCALE);
        $avgCost  = $this->safeAvgCost($newQty, $newValue);

        $balance->update([
            'on_hand'     => $newQty,
            'total_value' => $newValue,
            'avg_cost'    => $avgCost,
        ]);

        StockMovement::create([
            'product_id'   => $dto->productId,
            'warehouse_id' => $dto->warehouseId,
            'type'         => 'receipt',
            'qty_change'   => $qty,
            'unit_cost'    => $cost,
            'value_change' => $valueIn,
            'qty_after'    => $newQty,
            'value_after'  => $newValue,
            'avg_cost_after' => $avgCost,
            'source_type'  => $dto->sourceType,
            'source_id'    => $dto->sourceId,
            'occurred_at'  => $dto->occurredAt,
            'created_by'   => $dto->createdBy,
        ]);
    }

    public function deliver(StockOut $dto): void
    {
        $balance = $this->lockOrFail($dto->productId, $dto->warehouseId);

        $qty = $dto->qty;

        // Available check (on_hand - reserved)
        $available = bcsub($balance->on_hand, $balance->qty_reserved, self::QTY_SCALE);
        if (bccomp($qty, $available, self::QTY_SCALE) > 0) {
            throw new RuntimeException(
                "Stok tidak cukup: tersedia {$available}, dibutuhkan {$qty}"
            );
        }

        // Last-unit rule: if delivering entire on_hand, take all remaining value to avoid rounding drift
        $newQty = bcsub($balance->on_hand, $qty, self::QTY_SCALE);
        if (bccomp($newQty, '0', self::QTY_SCALE) === 0) {
            $valueCost = $balance->total_value; // take everything
        } else {
            // value_cost = round(total_value * qty / on_hand, 2)
            $valueCost = $this->round(
                bcdiv(bcmul($balance->total_value, $qty, 10), $balance->on_hand, 10),
                self::VAL_SCALE
            );
        }

        $newValue = bcsub($balance->total_value, $valueCost, self::VAL_SCALE);
        $avgCost  = $this->safeAvgCost($newQty, $newValue);
        $unitCost = bccomp($balance->on_hand, '0', self::QTY_SCALE) > 0
            ? $this->round(bcdiv($balance->total_value, $balance->on_hand, 10), self::COST_SCALE)
            : '0';

        $balance->update([
            'on_hand'     => $newQty,
            'total_value' => $newValue,
            'avg_cost'    => $avgCost,
        ]);

        StockMovement::create([
            'product_id'   => $dto->productId,
            'warehouse_id' => $dto->warehouseId,
            'type'         => 'delivery',
            'qty_change'   => '-' . $qty,   // signed negative
            'unit_cost'    => $unitCost,
            'value_change' => '-' . $valueCost,
            'qty_after'    => $newQty,
            'value_after'  => $newValue,
            'avg_cost_after' => $avgCost,
            'source_type'  => $dto->sourceType,
            'source_id'    => $dto->sourceId,
            'occurred_at'  => $dto->occurredAt,
            'created_by'   => $dto->createdBy,
        ]);
    }

    public function adjust(StockAdjustment $dto): void
    {
        $balance = $this->lockOrCreate($dto->productId, $dto->warehouseId);

        $diff = bcsub($dto->qtyCounted, $dto->qtySystem, self::QTY_SCALE);

        if (bccomp($diff, '0', self::QTY_SCALE) === 0) {
            return; // no movement needed
        }

        $isPositive = bccomp($diff, '0', self::QTY_SCALE) > 0;

        if ($isPositive) {
            // Adding stock: use provided unit_cost
            $valueDiff = $this->round(bcmul($diff, $dto->unitCost, 10), self::VAL_SCALE);
        } else {
            // Removing stock: use current avg_cost
            $absDiff   = ltrim($diff, '-');
            $valueDiff = '-' . $this->round(
                bcdiv(bcmul($balance->total_value, $absDiff, 10), $balance->on_hand, 10),
                self::VAL_SCALE
            );
        }

        $newQty   = bcadd($balance->on_hand, $diff, self::QTY_SCALE);
        $newValue = bcadd($balance->total_value, $valueDiff, self::VAL_SCALE);
        $avgCost  = $this->safeAvgCost($newQty, $newValue);

        if (bccomp($newQty, '0', self::QTY_SCALE) < 0) {
            throw new RuntimeException('Penyesuaian stok akan membuat stok menjadi negatif');
        }
        if (bccomp($newValue, '0', self::VAL_SCALE) < 0) {
            throw new RuntimeException('Penyesuaian stok akan membuat nilai menjadi negatif');
        }

        $balance->update([
            'on_hand'     => $newQty,
            'total_value' => $newValue,
            'avg_cost'    => $avgCost,
        ]);

        $unitCostForLog = $isPositive
            ? $dto->unitCost
            : ($balance->avg_cost ?? '0');

        StockMovement::create([
            'product_id'   => $dto->productId,
            'warehouse_id' => $dto->warehouseId,
            'type'         => 'adjustment',
            'qty_change'   => $diff,
            'unit_cost'    => $unitCostForLog,
            'value_change' => $valueDiff,
            'qty_after'    => $newQty,
            'value_after'  => $newValue,
            'avg_cost_after' => $avgCost,
            'source_type'  => $dto->sourceType,
            'source_id'    => $dto->sourceId,
            'occurred_at'  => $dto->occurredAt,
            'created_by'   => $dto->createdBy,
        ]);
    }

    // --- Helpers ---

    private function lockOrCreate(int $productId, int $warehouseId): StockBalance
    {
        return StockBalance::lockForUpdate()->firstOrCreate(
            ['product_id' => $productId, 'warehouse_id' => $warehouseId],
            ['on_hand' => '0', 'qty_reserved' => '0', 'total_value' => '0', 'avg_cost' => '0', 'reserved' => '0', 'unit_cost' => '0']
        );
    }

    private function lockOrFail(int $productId, int $warehouseId): StockBalance
    {
        return StockBalance::lockForUpdate()
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->firstOrFail();
    }

    private function safeAvgCost(string $qty, string $value): string
    {
        if (bccomp($qty, '0', self::QTY_SCALE) <= 0) {
            return '0';
        }
        return $this->round(bcdiv($value, $qty, 10), self::COST_SCALE);
    }

    /** Half-up rounding via bcmath (no float). */
    private function round(string $value, int $scale): string
    {
        $negative  = str_starts_with($value, '-');
        $abs       = $negative ? substr($value, 1) : $value;
        $half      = '0.' . str_repeat('0', $scale) . '5';
        $rounded   = bcsub(bcadd($abs, $half, $scale + 1), '0', $scale);
        return $negative ? '-' . $rounded : $rounded;
    }
}
