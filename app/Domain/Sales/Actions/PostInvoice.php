<?php

namespace App\Domain\Sales\Actions;

use App\Domain\Core\Contracts\PeriodGuard;
use App\Domain\Core\Events\InvoicePosted;
use App\Models\Delivery;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use RuntimeException;

class PostInvoice
{
    public function __construct(private PeriodGuard $periodGuard) {}

    public function execute(Invoice $invoice, int $postedBy): Invoice
    {
        return DB::transaction(function () use ($invoice, $postedBy) {
            if ($invoice->delivery_id) {
                Delivery::lockForUpdate()->findOrFail($invoice->delivery_id);
            }
            $invoice = Invoice::lockForUpdate()->findOrFail($invoice->id);

            if ($invoice->status !== 'draft') {
                throw new RuntimeException("Invoice {$invoice->number} sudah {$invoice->status}");
            }

            $this->periodGuard->assertOpen(Carbon::parse($invoice->invoice_date));

            $invoice->update([
                'status'    => 'open',
                'posted_at' => now(),
                'posted_by' => $postedBy,
            ]);

            Event::dispatch(new InvoicePosted($invoice->id, $postedBy));

            return $invoice->fresh();
        }, attempts: 3);
    }
}
