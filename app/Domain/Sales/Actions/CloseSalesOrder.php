<?php

namespace App\Domain\Sales\Actions;

use App\Models\SalesOrder;
use App\Models\StockBalance;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CloseSalesOrder
{
    public function execute(SalesOrder $so, int $closedBy): SalesOrder
    {
        return DB::transaction(function () use ($so, $closedBy) {
            $so = SalesOrder::with('lines')->lockForUpdate()->findOrFail($so->id);

            if (!in_array($so->status, ['confirmed', 'partial'])) {
                throw new RuntimeException("SO {$so->number} tidak bisa ditutup dari status {$so->status}");
            }

            // Release unreserved qty back to available
            foreach ($so->lines as $line) {
                $remaining = bcsub((string) $line->qty_reserved, (string) $line->qty_delivered, 4);
                if (bccomp($remaining, '0', 4) <= 0) continue;

                $balance = StockBalance::where('product_id', $line->product_id)
                    ->where('warehouse_id', $so->warehouse_id)
                    ->lockForUpdate()->first();

                if ($balance) {
                    $newReserved = bcsub((string) $balance->qty_reserved, $remaining, 4);
                    $balance->update(['qty_reserved' => max(0, (float) $newReserved)]);
                }

                $line->update(['qty_reserved' => $line->qty_delivered]);
            }

            $so->update([
                'status'       => 'cancelled',
                'cancelled_by' => $closedBy,
                'cancelled_at' => now(),
            ]);

            return $so->fresh();
        }, attempts: 3);
    }
}
