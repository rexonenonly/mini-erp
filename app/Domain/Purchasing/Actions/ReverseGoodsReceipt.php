<?php

namespace App\Domain\Purchasing\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Contracts\StockLedger;
use App\Domain\Core\DTO\StockAdjustment;
use App\Models\GoodsReceipt;
use App\Models\JournalEntry;
use App\Domain\Accounting\Services\JournalPoster;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReverseGoodsReceipt
{
    public function __construct(
        private PeriodGuard $periodGuard,
        private StockLedger $stockLedger,
        private JournalPoster $journalPoster,
    ) {}

    public function execute(GoodsReceipt $gr, int $reversedBy): GoodsReceipt
    {
        return DB::transaction(function () use ($gr, $reversedBy) {
            $gr = GoodsReceipt::with('lines')->lockForUpdate()->findOrFail($gr->id);

            if ($gr->status !== 'posted') {
                throw new RuntimeException("GR {$gr->number} bukan status posted, tidak bisa dibalik");
            }

            // Check no VendorBill references this GR (would orphan)
            $hasBill = DB::table('vendor_bills')
                ->where('receipt_id', $gr->id)
                ->whereNot('status', 'reversed')
                ->exists();

            if ($hasBill) {
                throw new RuntimeException("GR {$gr->number} sudah memiliki tagihan aktif, balik tagihan dulu");
            }

            $this->periodGuard->assertOpen(now());

            // Reverse stock movements — use adjust (negative diff)
            foreach ($gr->lines as $line) {
                $this->stockLedger->adjust(new StockAdjustment(
                    productId:   $line->product_id,
                    warehouseId: $gr->warehouse_id,
                    qtySystem:   (string) $line->qty_received,
                    qtyCounted:  '0',  // removing all received qty
                    unitCost:    (string) $line->unit_cost,
                    sourceType:  'goods_receipt_reversal',
                    sourceId:    $gr->id,
                    occurredAt:  now(),
                    createdBy:   $reversedBy,
                ));
            }

            // Reverse journal
            $journal = JournalEntry::where('source_type', 'goods_receipt')
                ->where('source_id', $gr->id)
                ->where('status', 'posted')
                ->first();

            if ($journal) {
                $this->journalPoster->reverse($journal, now(), $reversedBy);
            }

            $gr->update([
                'status'      => 'reversed',
                'reversed_by' => $reversedBy,
                'reversed_at' => now(),
            ]);

            return $gr->fresh();
        }, attempts: 3);
    }
}
