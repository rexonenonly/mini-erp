<?php

namespace App\Domain\Sales\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Contracts\StockLedger;
use App\Domain\Core\Events\DeliveryPosted;
use App\Domain\Inventory\DTO\StockOut;
use App\Models\Delivery;
use App\Models\SalesOrder;
use App\Models\SalesOrderLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostDelivery
{
    public function __construct(
        private PeriodGuard $periodGuard,
        private StockLedger $stockLedger,
    ) {}

    public function execute(Delivery $delivery, int $postedBy): Delivery
    {
        return DB::transaction(function () use ($delivery, $postedBy) {
            // Lock order: SO, then Delivery
            $so = SalesOrder::with('lines')->lockForUpdate()
                ->findOrFail($delivery->sales_order_id);
            $delivery = Delivery::with('lines')->lockForUpdate()->findOrFail($delivery->id);

            if ($delivery->status !== 'draft') {
                throw new RuntimeException("DO {$delivery->number} sudah {$delivery->status}");
            }

            $this->periodGuard->assertOpen(Carbon::parse($delivery->delivery_date));

            $totalCost = '0.00';

            foreach ($delivery->lines as $line) {
                $qty = (string) $line->qty;
                $unitCost = $line->unit_cost ?: '0';

                // Deduct stock from ledger (exact HPP)
                $this->stockLedger->deliver(new StockOut(
                    productId:   $line->product_id,
                    warehouseId: $delivery->warehouse_id,
                    qty:         $qty,
                    sourceType:  'delivery',
                    sourceId:    $delivery->id,
                    occurredAt:  Carbon::parse($delivery->delivery_date),
                    createdBy:   $postedBy,
                ));

                // Read avg_cost from stock_movements for this delivery line
                $lastMove = \App\Models\StockMovement::where('product_id', $line->product_id)
                    ->where('source_type', 'delivery')
                    ->where('source_id', $delivery->id)
                    ->latest('id')->first();

                $actualUnitCost = $lastMove ? (string) $lastMove->unit_cost : '0';
                $lineCost = bcmul($qty, $actualUnitCost, 2);
                $totalCost = bcadd($totalCost, $lineCost, 2);

                $line->update([
                    'unit_cost' => $actualUnitCost,
                    'line_cost' => $lineCost,
                    'subtotal'  => $lineCost,
                ]);

                // Update SO line qty_delivered, decrement reserved
                $soLine = SalesOrderLine::find($line->sales_order_item_id);
                if ($soLine) {
                    $soLine->increment('qty_delivered', $line->qty);
                    $soLine->decrement('qty_reserved', $line->qty);
                }

                // Decrement stock_balances qty_reserved
                $balance = \App\Models\StockBalance::where('product_id', $line->product_id)
                    ->where('warehouse_id', $delivery->warehouse_id)
                    ->first();

                if ($balance) {
                    $newReserved = bcsub((string) $balance->qty_reserved, $qty, 4);
                    $newReserved = max(0, (float) $newReserved);
                    $balance->update(['qty_reserved' => $newReserved]);
                }
            }

            // Update SO status
            $allDelivered = $so->fresh()->lines->every(fn ($l) =>
                bccomp((string) $l->qty_delivered, (string) $l->qty_ordered, 4) >= 0
            );
            $so->update(['status' => $allDelivered ? 'done' : 'confirmed']);

            $delivery->update([
                'status'     => 'posted',
                'total_cost' => $totalCost,
                'posted_at'  => now(),
                'posted_by'  => $postedBy,
            ]);

            Event::dispatch(new DeliveryPosted($delivery->id, $postedBy));

            return $delivery->fresh();
        }, attempts: 3);
    }
}
