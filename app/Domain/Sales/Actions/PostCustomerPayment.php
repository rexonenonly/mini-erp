<?php

namespace App\Domain\Sales\Actions;

use App\Domain\Core\Events\PaymentPosted;
use App\Models\CustomerPayment;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostCustomerPayment
{
    public function execute(CustomerPayment $payment, int $postedBy): CustomerPayment
    {
        return DB::transaction(function () use ($payment, $postedBy) {
            if ($payment->invoice_id) {
                $invoice = Invoice::lockForUpdate()->findOrFail($payment->invoice_id);
            }
            $payment = CustomerPayment::lockForUpdate()->findOrFail($payment->id);

            if ($payment->status !== 'draft') {
                throw new RuntimeException("Pembayaran {$payment->number} sudah {$payment->status}");
            }

            if (isset($invoice)) {
                $outstanding = bcsub((string) $invoice->total_amount, (string) $invoice->paid_amount, 2);
                if (bccomp((string) $payment->amount, $outstanding, 2) > 0) {
                    throw new RuntimeException(
                        "Pembayaran Rp {$payment->amount} melebihi sisa piutang Rp {$outstanding}"
                    );
                }

                $newPaid = bcadd((string) $invoice->paid_amount, (string) $payment->amount, 2);
                $newStatus = bccomp($newPaid, (string) $invoice->total_amount, 2) >= 0
                    ? 'paid'
                    : 'partially_paid';

                $invoice->update(['paid_amount' => $newPaid, 'status' => $newStatus]);
            }

            $payment->update([
                'status'    => 'posted',
                'posted_at' => now(),
                'posted_by' => $postedBy,
            ]);

            Event::dispatch(new PaymentPosted($payment->id, 'in', $postedBy));

            return $payment->fresh();
        }, attempts: 3);
    }
}
