<?php

namespace App\Domain\Purchasing\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Events\VendorBillPosted;
use App\Models\GoodsReceipt;
use App\Models\VendorBill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostVendorBill
{
    public function __construct(private PeriodGuard $periodGuard) {}

    public function execute(VendorBill $bill, int $postedBy): VendorBill
    {
        return DB::transaction(function () use ($bill, $postedBy) {
            // Lock order: GR → Bill
            if ($bill->receipt_id) {
                GoodsReceipt::lockForUpdate()->findOrFail($bill->receipt_id);
            }
            $bill = VendorBill::lockForUpdate()->findOrFail($bill->id);

            if ($bill->status !== 'draft') {
                throw new RuntimeException("Tagihan {$bill->number} sudah {$bill->status}");
            }

            $this->periodGuard->assertOpen(Carbon::parse($bill->bill_date));

            $bill->update([
                'status'    => 'open',
                'posted_at' => now(),
                'posted_by' => $postedBy,
            ]);

            Event::dispatch(new VendorBillPosted($bill->id, $postedBy));

            return $bill->fresh();
        }, attempts: 3);
    }
}
