<?php

namespace App\Domain\Sales\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Contracts\StockLedger;
use App\Models\SalesOrder;
use App\Models\SalesOrderLine;
use App\Models\StockBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ConfirmSalesOrder
{
    public function __construct(
        private PeriodGuard $periodGuard,
        private StockLedger $stockLedger,
    ) {}

    public function execute(SalesOrder $so, int $confirmedBy): SalesOrder
    {
        return DB::transaction(function () use ($so, $confirmedBy) {
            // Lock order: SO, then all stock_balances for its items
            $so = SalesOrder::with('lines')->lockForUpdate()->findOrFail($so->id);

            if ($so->status !== 'draft') {
                throw new RuntimeException("SO {$so->number} sudah {$so->status}");
            }

            $this->periodGuard->assertOpen(Carbon::parse($so->order_date));

            foreach ($so->lines as $line) {
                // Lock stock_balances in consistent order (by product_id)
                $balance = StockBalance::where('product_id', $line->product_id)
                    ->where('warehouse_id', $so->warehouse_id)
                    ->lockForUpdate()
                    ->first();

                $available = $balance ? (float) $balance->on_hand - (float) $balance->qty_reserved : 0;
                $needed = (float) $line->qty_ordered;

                if ($available < $needed) {
                    throw new RuntimeException(
                        "Stok tidak cukup untuk {$line->product->sku}: tersedia {$available}, butuh {$needed}"
                    );
                }

                // Increment reserved
                if ($balance) {
                    $newReserved = bcadd((string) $balance->qty_reserved, (string) $line->qty_ordered, 4);
                    $balance->update(['qty_reserved' => $newReserved]);
                }

                // Update line qty_reserved
                $line->update(['qty_reserved' => $line->qty_ordered]);
            }

            $so->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => $confirmedBy,
            ]);

            // Fire SalesOrderConfirmed event (create listener in Phase 3 — already registered)
            // ponytail: event not yet dispatched, add when SalesOrderConfirmed listener ready
            return $so->fresh();
        }, attempts: 3);
    }
}
