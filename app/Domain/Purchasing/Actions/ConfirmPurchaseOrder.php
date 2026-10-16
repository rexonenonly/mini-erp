<?php

namespace App\Domain\Purchasing\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ConfirmPurchaseOrder
{
    public function __construct(private PeriodGuard $periodGuard) {}

    public function execute(PurchaseOrder $po, int $confirmedBy): PurchaseOrder
    {
        return DB::transaction(function () use ($po, $confirmedBy) {
            // Lock PO
            $po = PurchaseOrder::lockForUpdate()->findOrFail($po->id);

            // Idempotent: already confirmed?
            if ($po->status !== 'draft') {
                throw new RuntimeException("PO {$po->number} is already {$po->status}, cannot confirm");
            }

            // Period open
            $this->periodGuard->assertOpen($po->order_date);

            // Confirm
            $po->update([
                'status' => 'confirmed',
                'confirmed_by' => $confirmedBy,
                'confirmed_at' => now(),
            ]);

            return $po->fresh();
        }, attempts: 3);
    }
}
