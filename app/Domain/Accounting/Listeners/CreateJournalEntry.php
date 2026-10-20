<?php

namespace App\Domain\Accounting\Listeners;

use App\Domain\Accounting\Services\JournalPoster;
use App\Domain\Core\Events\DeliveryPosted;
use App\Domain\Core\Events\GoodsReceiptPosted;
use App\Domain\Core\Events\InvoicePosted;
use App\Domain\Core\Events\PaymentPosted;
use App\Domain\Core\Events\StockOpnamePosted;
use App\Domain\Core\Events\VendorBillPosted;
use App\Models\Delivery;
use App\Models\GoodsReceipt;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\StockOpname;
use App\Models\VendorBill;
use Carbon\Carbon;

/**
 * Single listener handling all domain events → journal entries.
 * NOT queued — runs synchronously inside the posting transaction.
 *
 * ponytail: All posting logic is in this one class. Split into per-domain
 *           listeners if team grows and conflict rate increases.
 */
class CreateJournalEntry
{
    public function __construct(private JournalPoster $poster) {}

    public function handleGoodsReceiptPosted(GoodsReceiptPosted $event): void
    {
        $gr = GoodsReceipt::with('lines')->findOrFail($event->receiptId);

        $this->poster->post(
            sourceType:  'goods_receipt',
            sourceId:    $gr->id,
            description: "GR {$gr->number}",
            lines: [
                ['account_key' => 'inventory', 'debit' => $gr->total_value, 'credit' => 0],
                ['account_key' => 'grir',       'debit' => 0, 'credit' => $gr->total_value],
            ],
            entryDate:  Carbon::parse($gr->receipt_date),
            createdBy:  $event->userId,
        );
    }

    public function handleVendorBillPosted(VendorBillPosted $event): void
    {
        $bill = VendorBill::findOrFail($event->billId);

        $this->poster->post(
            sourceType:  'vendor_bill',
            sourceId:    $bill->id,
            description: "VB {$bill->number}",
            lines: [
                ['account_key' => 'grir',    'debit' => $bill->total, 'credit' => 0,          'partner_id' => $bill->supplier_id],
                ['account_key' => 'payable', 'debit' => 0,            'credit' => $bill->total, 'partner_id' => $bill->supplier_id],
            ],
            entryDate:  Carbon::parse($bill->bill_date),
            createdBy:  $event->userId,
        );
    }

    public function handlePaymentPosted(PaymentPosted $event): void
    {
        $payment = Payment::findOrFail($event->paymentId);

        if ($event->direction === 'out') {
            $lines = [
                ['account_key' => 'payable',             'debit' => $payment->amount, 'credit' => 0,                'partner_id' => $payment->partner_id],
                ['account_id'  => $payment->account_id,  'debit' => 0,               'credit' => $payment->amount],
            ];
        } else {
            $lines = [
                ['account_id'  => $payment->account_id,  'debit' => $payment->amount, 'credit' => 0],
                ['account_key' => 'receivable',          'debit' => 0,               'credit' => $payment->amount, 'partner_id' => $payment->partner_id],
            ];
        }

        $this->poster->post(
            sourceType:  'payment',
            sourceId:    $payment->id,
            description: "Payment {$payment->number}",
            lines:       $lines,
            entryDate:   Carbon::parse($payment->paid_at),
            createdBy:   $event->userId,
        );
    }

    public function handleDeliveryPosted(DeliveryPosted $event): void
    {
        $delivery = Delivery::findOrFail($event->deliveryId);

        $this->poster->post(
            sourceType:  'delivery',
            sourceId:    $delivery->id,
            description: "DO {$delivery->number}",
            lines: [
                ['account_key' => 'cogs',      'debit' => $delivery->total_cost, 'credit' => 0],
                ['account_key' => 'inventory', 'debit' => 0, 'credit' => $delivery->total_cost],
            ],
            entryDate:  Carbon::parse($delivery->delivery_date),
            createdBy:  $event->userId,
        );
    }

    public function handleInvoicePosted(InvoicePosted $event): void
    {
        $invoice = Invoice::findOrFail($event->invoiceId);

        $this->poster->post(
            sourceType:  'invoice',
            sourceId:    $invoice->id,
            description: "INV {$invoice->number}",
            lines: [
                ['account_key' => 'receivable', 'debit' => $invoice->total, 'credit' => 0,              'partner_id' => $invoice->customer_id],
                ['account_key' => 'sales',      'debit' => 0,              'credit' => $invoice->total],
            ],
            entryDate:  Carbon::parse($invoice->invoice_date),
            createdBy:  $event->userId,
        );
    }

    public function handleStockOpnamePosted(StockOpnamePosted $event): void
    {
        $opname = StockOpname::findOrFail($event->opnameId);

        // net_value can be positive (surplus) or negative (deficit)
        $netValue = $opname->net_value ?? 0;

        if ((float) $netValue === 0.0) {
            return; // nothing to post
        }

        $absValue = abs((float) $netValue);

        if ((float) $netValue > 0) {
            $lines = [
                ['account_key' => 'inventory',             'debit' => $absValue, 'credit' => 0],
                ['account_key' => 'inventory_adjustment',  'debit' => 0, 'credit' => $absValue],
            ];
        } else {
            $lines = [
                ['account_key' => 'inventory_adjustment',  'debit' => $absValue, 'credit' => 0],
                ['account_key' => 'inventory',             'debit' => 0, 'credit' => $absValue],
            ];
        }

        $this->poster->post(
            sourceType:  'stock_opname',
            sourceId:    $opname->id,
            description: "Opname {$opname->number}",
            lines:       $lines,
            entryDate:   Carbon::parse($opname->opname_date),
            createdBy:   $event->userId,
        );
    }

    /** Register all event→handler mappings. */
    public function subscribe($events): array
    {
        return [
            GoodsReceiptPosted::class => 'handleGoodsReceiptPosted',
            VendorBillPosted::class   => 'handleVendorBillPosted',
            PaymentPosted::class      => 'handlePaymentPosted',
            DeliveryPosted::class     => 'handleDeliveryPosted',
            InvoicePosted::class      => 'handleInvoicePosted',
            StockOpnamePosted::class  => 'handleStockOpnamePosted',
        ];
    }
}
