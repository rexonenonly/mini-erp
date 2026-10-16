<?php

namespace App\Domain\Purchasing\Actions;

use App\Domain\Core\Events\PaymentPosted;
use App\Models\SupplierPayment;
use App\Models\VendorBill;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostSupplierPayment
{
    public function execute(SupplierPayment $payment, int $postedBy): SupplierPayment
    {
        return DB::transaction(function () use ($payment, $postedBy) {
            // Lock order: Bill → Payment
            if ($payment->bill_id) {
                $bill = VendorBill::lockForUpdate()->findOrFail($payment->bill_id);
            }
            $payment = SupplierPayment::lockForUpdate()->findOrFail($payment->id);

            if ($payment->status !== 'draft') {
                throw new RuntimeException("Pembayaran {$payment->number} sudah {$payment->status}");
            }

            // Validate amount doesn't exceed outstanding
            if (isset($bill)) {
                $outstanding = bcsub((string) $bill->total_amount, (string) $bill->paid_amount, 2);
                if (bccomp((string) $payment->amount, $outstanding, 2) > 0) {
                    throw new RuntimeException(
                        "Pembayaran Rp {$payment->amount} melebihi sisa tagihan Rp {$outstanding}"
                    );
                }

                $newPaid = bcadd((string) $bill->paid_amount, (string) $payment->amount, 2);
                $newStatus = bccomp($newPaid, (string) $bill->total_amount, 2) >= 0
                    ? 'paid'
                    : 'partially_paid';

                $bill->update(['paid_amount' => $newPaid, 'status' => $newStatus]);
            }

            $payment->update([
                'status'    => 'posted',
                'posted_at' => now(),
                'posted_by' => $postedBy,
            ]);

            Event::dispatch(new PaymentPosted($payment->id, 'out', $postedBy));

            return $payment->fresh();
        }, attempts: 3);
    }
}
