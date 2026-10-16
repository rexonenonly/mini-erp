<?php

use App\Domain\Purchasing\Actions\ConfirmPurchaseOrder;
use App\Domain\Purchasing\Actions\PostGoodsReceipt;
use App\Domain\Purchasing\Actions\PostVendorBill;
use App\Domain\Purchasing\Actions\PostSupplierPayment;
use App\Domain\Core\Events\GoodsReceiptPosted;
use App\Domain\Core\Events\VendorBillPosted;
use App\Domain\Core\Events\PaymentPosted;
use App\Models\FiscalPeriod;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptLine;
use App\Models\Partner;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderLine;
use App\Models\StockBalance;
use App\Models\SupplierPayment;
use App\Models\User;
use App\Models\VendorBill;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Minimal factory helpers
function makeSupplier(): Partner
{
    return Partner::create(['code' => 'SUPP-A', 'name' => 'Supplier A', 'type' => 'supplier', 'email' => 'a@a.com']);
}

function makeWarehouse(): Warehouse
{
    return Warehouse::create(['name' => 'Gudang 1', 'code' => 'G1', 'location' => '-']);
}

function makeProduct(string $sku = 'P001'): Product
{
    return Product::create([
        'name' => 'Produk ' . $sku, 'sku' => $sku, 'unit' => 'pcs',
        'purchase_price' => '100000', 'sale_price' => '150000',
        'min_stock' => 0, 'is_active' => true,
    ]);
}

function makeUser(): User
{
    return User::factory()->create();
}

function ensurePeriodOpen(\Carbon\Carbon $date): FiscalPeriod
{
    return FiscalPeriod::firstOrCreate(
        ['year' => $date->year, 'month' => $date->month],
        [
            'name' => $date->format('Y-m'),
            'start_date' => $date->copy()->startOfMonth(),
            'end_date' => $date->copy()->endOfMonth(),
            'status' => 'open',
        ],
    );
}

// --

test('ConfirmPurchaseOrder: draft → confirmed', function () {
    $user = makeUser();
    $supplier = makeSupplier();
    $warehouse = makeWarehouse();
    $today = now()->startOfDay();
    ensurePeriodOpen($today);

    $po = PurchaseOrder::create([
        'number' => 'PO-001', 'order_date' => $today,
        'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => '500000', 'status' => 'draft', 'created_by' => $user->id,
    ]);

    $action = app(ConfirmPurchaseOrder::class);
    $result = $action->execute($po, $user->id);

    expect($result->status)->toBe('confirmed')
        ->and($result->confirmed_by)->toBe($user->id);
});

test('ConfirmPurchaseOrder: already confirmed throws', function () {
    $user = makeUser();
    $supplier = makeSupplier();
    $warehouse = makeWarehouse();
    ensurePeriodOpen(now());

    $po = PurchaseOrder::create([
        'number' => 'PO-002', 'order_date' => now(),
        'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => '0', 'status' => 'confirmed', 'created_by' => $user->id,
    ]);

    expect(fn () => app(ConfirmPurchaseOrder::class)->execute($po, $user->id))
        ->toThrow(RuntimeException::class);
});

test('PostGoodsReceipt: fires event and updates stock', function () {
    Event::fake([GoodsReceiptPosted::class]);

    $user = makeUser();
    $supplier = makeSupplier();
    $warehouse = makeWarehouse();
    $product = makeProduct();
    ensurePeriodOpen(now());

    $po = PurchaseOrder::create([
        'number' => 'PO-003', 'order_date' => now(),
        'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => '1000000', 'status' => 'confirmed', 'created_by' => $user->id,
    ]);
    $poLine = PurchaseOrderLine::create([
        'purchase_order_id' => $po->id, 'product_id' => $product->id,
        'qty_ordered' => '10', 'qty_received' => '0',
        'unit' => 'pcs', 'unit_price' => '100000', 'subtotal' => '1000000',
    ]);

    $gr = GoodsReceipt::create([
        'number' => 'GR-001', 'receipt_date' => now(),
        'purchase_order_id' => $po->id, 'supplier_id' => $supplier->id,
        'warehouse_id' => $warehouse->id, 'status' => 'draft', 'created_by' => $user->id,
    ]);
    GoodsReceiptLine::create([
        'goods_receipt_id' => $gr->id,
        'purchase_order_item_id' => $poLine->id,
        'product_id' => $product->id,
        'qty_received' => '10', 'unit' => 'pcs',
        'unit_cost' => '100000', 'subtotal' => '1000000',
    ]);

    $result = app(PostGoodsReceipt::class)->execute($gr, $user->id);

    expect($result->status)->toBe('posted');
    Event::assertDispatched(GoodsReceiptPosted::class, fn ($e) => $e->receiptId === $gr->id);

    $balance = StockBalance::where('product_id', $product->id)
        ->where('warehouse_id', $warehouse->id)
        ->first();

    expect($balance)->not->toBeNull()
        ->and((float) $balance->on_hand)->toBe(10.0)
        ->and((float) $balance->avg_cost)->toBe(100000.0);
});

test('PostVendorBill: draft → open, fires event', function () {
    Event::fake([VendorBillPosted::class]);

    $user = makeUser();
    $supplier = makeSupplier();
    ensurePeriodOpen(now());

    $bill = VendorBill::create([
        'number' => 'VB-001', 'bill_date' => now(), 'due_date' => now()->addDays(30),
        'supplier_id' => $supplier->id, 'total_amount' => '500000',
        'paid_amount' => '0', 'status' => 'draft', 'created_by' => $user->id,
    ]);

    $result = app(PostVendorBill::class)->execute($bill, $user->id);

    expect($result->status)->toBe('open');
    Event::assertDispatched(VendorBillPosted::class, fn ($e) => $e->billId === $bill->id);
});

test('PostSupplierPayment: posted, updates bill paid_amount', function () {
    Event::fake([PaymentPosted::class]);

    $user = makeUser();
    $supplier = makeSupplier();
    ensurePeriodOpen(now());

    $bill = VendorBill::create([
        'number' => 'VB-002', 'bill_date' => now(), 'due_date' => now()->addDays(30),
        'supplier_id' => $supplier->id, 'total_amount' => '500000',
        'paid_amount' => '0', 'status' => 'open', 'created_by' => $user->id,
    ]);

    $payment = SupplierPayment::create([
        'number' => 'SP-001', 'payment_date' => now(),
        'bill_id' => $bill->id, 'supplier_id' => $supplier->id,
        'amount' => '500000', 'method' => 'transfer', 'status' => 'draft', 'created_by' => $user->id,
    ]);

    $result = app(PostSupplierPayment::class)->execute($payment, $user->id);

    expect($result->status)->toBe('posted');
    Event::assertDispatched(PaymentPosted::class);

    $bill->refresh();
    expect((float) $bill->paid_amount)->toBe(500000.0)
        ->and($bill->status)->toBe('paid');
});

test('PostSupplierPayment: overpayment rejected', function () {
    $user = makeUser();
    $supplier = makeSupplier();

    $bill = VendorBill::create([
        'number' => 'VB-003', 'bill_date' => now(), 'due_date' => now()->addDays(30),
        'supplier_id' => $supplier->id, 'total_amount' => '300000',
        'paid_amount' => '0', 'status' => 'open', 'created_by' => $user->id,
    ]);

    $payment = SupplierPayment::create([
        'number' => 'SP-002', 'payment_date' => now(),
        'bill_id' => $bill->id, 'supplier_id' => $supplier->id,
        'amount' => '500000', 'method' => 'transfer', 'status' => 'draft', 'created_by' => $user->id,
    ]);

    expect(fn () => app(PostSupplierPayment::class)->execute($payment, $user->id))
        ->toThrow(RuntimeException::class, 'melebihi');
});
