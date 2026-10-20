<?php

use App\Domain\Purchasing\Actions\ConfirmPurchaseOrder;
use App\Domain\Purchasing\Actions\PostGoodsReceipt;
use App\Domain\Purchasing\Actions\PostVendorBill;
use App\Domain\Purchasing\Actions\PostSupplierPayment;
use App\Models\GoodsReceipt;
use App\Models\FiscalPeriod;
use App\Models\JournalEntry;
use App\Models\Partner;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SupplierPayment;
use App\Models\User;
use App\Models\VendorBill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('full purchasing flow: PO → GR → Bill → Payment', function () {
    $user = User::factory()->create();
    $vendor = Partner::create(['code' => 'V001', 'name' => 'Vendor A', 'type' => 'supplier', 'email' => 'v@example.com']);
    $product = Product::create(['code' => 'P001', 'sku' => 'SKU-P001', 'name' => 'Product A', 'unit' => 'pcs', 'purchase_price' => '5000', 'sale_price' => '8000', 'min_stock' => 0, 'is_active' => true]);
    $warehouse = \App\Models\Warehouse::create(['code' => 'WH01', 'name' => 'Main Warehouse', 'location' => '-']);
    $today = now()->startOfDay();
    FiscalPeriod::create(['name' => $today->format('Y-m'), 'year' => $today->year, 'month' => $today->month, 'start_date' => $today->copy()->startOfMonth(), 'end_date' => $today->copy()->endOfMonth(), 'status' => 'open']);

    // Step 1: Create PO
    $po = PurchaseOrder::create([
        'number' => 'PO-TEST-001',
        'supplier_id' => $vendor->id,
        'warehouse_id' => $warehouse->id,
        'order_date' => $today,
        'total_amount' => '50000',
        'status' => 'draft',
        'created_by' => $user->id,
    ]);
    $po->lines()->create(['product_id' => $product->id, 'qty_ordered' => '10.000', 'unit' => 'pcs', 'unit_price' => '5000.00', 'subtotal' => '50000.00']);

    // Step 2: Confirm PO
    $action = app(ConfirmPurchaseOrder::class);
    $po = $action->execute($po->fresh(), $user->id);
    expect($po->status)->toBe('confirmed')
        ->and($po->confirmed_by)->toBe($user->id);

    // Step 3: Create + Post GR
    $gr = GoodsReceipt::create([
        'number' => 'GR-TEST-001',
        'purchase_order_id' => $po->id,
        'supplier_id' => $vendor->id,
        'warehouse_id' => $warehouse->id,
        'receipt_date' => $today,
        'status' => 'draft',
        'created_by' => $user->id,
    ]);
    $gr->lines()->create(['product_id' => $product->id, 'purchase_order_line_id' => $po->lines->first()->id, 'qty_received' => '10.000', 'unit' => 'pcs', 'unit_cost' => '5000.00', 'subtotal' => '50000.00']);

    $action = app(PostGoodsReceipt::class);
    $gr = $action->execute($gr->fresh(), $user->id);
    expect($gr->status)->toBe('posted')
        ->and($gr->posted_by)->toBe($user->id);

    $journal = JournalEntry::where('source_type', 'goods_receipt')->where('source_id', $gr->id)->first();
    expect($journal)->not->toBeNull()
        ->and($journal->lines->sum('debit'))->toBe($journal->lines->sum('credit'));

    // Step 4: Create + Post Bill
    $bill = VendorBill::create([
        'number' => 'BILL-TEST-001',
        'supplier_id' => $vendor->id,
        'receipt_id' => $gr->id,
        'bill_date' => $today,
        'due_date' => $today->copy()->addDays(30),
        'total_amount' => '50000.00',
        'status' => 'draft',
        'created_by' => $user->id,
    ]);

    $action = app(PostVendorBill::class);
    $bill = $action->execute($bill->fresh(), $user->id);
    expect($bill->status)->toBe('open')
        ->and($bill->posted_by)->toBe($user->id);

    $journal = JournalEntry::where('source_type', 'vendor_bill')->where('source_id', $bill->id)->first();
    expect($journal)->not->toBeNull();

    // Step 5: Create + Post Payment
    $payment = SupplierPayment::create([
        'number' => 'PAY-TEST-001',
        'supplier_id' => $vendor->id,
        'bill_id' => $bill->id,
        'payment_date' => $today,
        'amount' => '50000.00',
        'status' => 'draft',
        'created_by' => $user->id,
    ]);

    $action = app(PostSupplierPayment::class);
    $payment = $action->execute($payment->fresh(), $user->id);
    expect($payment->status)->toBe('posted')
        ->and($payment->posted_by)->toBe($user->id);

    $bill->refresh();
    expect($bill->paid_amount)->toBe('50000.00')
        ->and($bill->status)->toBe('paid');

    $journal = JournalEntry::where('source_type', 'supplier_payment')->where('source_id', $payment->id)->first();
    expect($journal)->not->toBeNull()
        ->and($journal->lines->sum('debit'))->toBe($journal->lines->sum('credit'));
});
