<?php

namespace App\Domain\Purchasing\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Contracts\StockLedger;
use App\Domain\Core\Events\GoodsReceiptPosted;
use App\Domain\Core\DTO\StockIn;
use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostGoodsReceipt
{
    public function __construct(
        private PeriodGuard $periodGuard,
        private StockLedger $stockLedger,
    ) {}

    public function execute(GoodsReceipt $gr, int $postedBy): GoodsReceipt
    {
        return DB::transaction(function () use ($gr, $postedBy) {
            // Lock GR (order: PO first, then GR, consistent across all callers)
            if ($gr->purchase_order_id) {
                PurchaseOrder::lockForUpdate()->findOrFail($gr->purchase_order_id);
            }
            $gr = GoodsReceipt::with('lines.product')->lockForUpdate()->findOrFail($gr->id);

            if ($gr->status !== 'draft') {
                throw new RuntimeException("GR {$gr->number} sudah {$gr->status}, tidak bisa diposting");
            }
            if ($gr->lines->isEmpty()) {
                throw new RuntimeException("GR {$gr->number} tidak ada item");
            }

            $this->periodGuard->assertOpen(Carbon::parse($gr->receipt_date));

            $totalValue = '0.00';

            foreach ($gr->lines as $line) {
                $lineValue = bcmul((string) $line->qty_received, (string) $line->unit_cost, 2);
                $totalValue = bcadd($totalValue, $lineValue, 2);

                $this->stockLedger->receive(new StockIn(
                    productId:   $line->product_id,
                    warehouseId: $gr->warehouse_id,
                    qty:         (string) $line->qty_received,
                    unitCost:    (string) $line->unit_cost,
                    sourceType:  'goods_receipt',
                    sourceId:    $gr->id,
                    occurredAt:  Carbon::parse($gr->receipt_date),
                    createdBy:   $postedBy,
                ));

                // Update PO item qty_received
                if ($line->purchase_order_item_id) {
                    DB::table('purchase_order_lines')
                        ->where('id', $line->purchase_order_item_id)
                        ->increment('qty_received', $line->qty_received);
                }
            }

            // Update PO status: partial or done
            if ($gr->purchase_order_id) {
                $this->updatePoStatus($gr->purchase_order_id);
            }

            $gr->update([
                'status'     => 'posted',
                'total_value' => $totalValue,
                'posted_at'  => now(),
                'posted_by'  => $postedBy,
            ]);

            Event::dispatch(new GoodsReceiptPosted($gr->id, $postedBy));

            return $gr->fresh();
        }, attempts: 3);
    }

    private function updatePoStatus(int $poId): void
    {
        $po = PurchaseOrder::with('lines')->find($poId);
        if (!$po) return;

        $allDone = $po->lines->every(fn ($l) =>
            bccomp((string) $l->qty_received, (string) $l->qty_ordered, 4) >= 0
        );

        $po->update(['status' => $allDone ? 'done' : 'partial']);
    }
}
