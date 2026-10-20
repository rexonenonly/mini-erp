<?php

use App\Domain\Sales\Actions\ConfirmSalesOrder;
use App\Domain\Sales\Actions\PostDelivery;
use App\Domain\Sales\Actions\PostInvoice;
use App\Domain\Sales\Actions\PostCustomerPayment;
use App\Domain\Core\Events\DeliveryPosted;
use App\Domain\Core\Events\InvoicePosted;
use App\Domain\Core\Events\PaymentPosted;
use App\Models\CustomerPayment;
use App\Models\Delivery;
use App\Models\DeliveryLine;
use App\Models\FiscalPeriod;
use App\Models\Invoice;
use App\Models\Partner;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderLine;
use App\Models\StockBalance;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\ChartOfAccountsSeeder::class]);
    $this->cashAccount = \App\Models\Account::where('system_key', 'cash')->firstOrFail();
});

function salesSetup(): array
{
    $user = User::factory()->create();
    $customer = Partner::create(['code' => 'CUST-1', 'name' => 'Customer A', 'type' => 'customer', 'email' => 'c@c.com']);
    $warehouse = Warehouse::create(['name' => 'G1', 'code' => 'G1', 'location' => '-']);
    $product = Product::create(['name' => 'Barang', 'sku' => 'B001', 'unit' => 'pcs', 'purchase_price' => 100000, 'sale_price' => 150000, 'min_stock' => 0, 'is_active' => true]);

    // Seed existing stock + balance (simulate prior GR)
    $balance = StockBalance::create([
        'product_id'   => $product->id,
        'warehouse_id' => $warehouse->id,
        'on_hand'      => 50,
        'reserved'     => 0,
        'qty_reserved' => 0,
        'total_value'  => '5000000.00',
        'avg_cost'     => '100000.0000',
        'unit_cost'    => '100000.00',
    ]);

    $date = now()->startOfMonth();
    FiscalPeriod::firstOrCreate(
        ['year' => $date->year, 'month' => $date->month],
        ['name' => $date->format('Y-m'), 'start_date' => $date, 'end_date' => $date->copy()->endOfMonth(), 'status' => 'open']
    );

    return compact('user', 'customer', 'warehouse', 'product', 'balance');
}

test('ConfirmSalesOrder: reserves stock', function () {
    ['user' => $user, 'customer' => $customer, 'warehouse' => $warehouse, 'product' => $product, 'balance' => $balance] = salesSetup();

    $so = SalesOrder::create([
        'number' => 'SO-001', 'order_date' => now(),
        'customer_id' => $customer->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => '1500000', 'status' => 'draft', 'created_by' => $user->id,
    ]);
    SalesOrderLine::create([
        'sales_order_id' => $so->id, 'product_id' => $product->id,
        'qty_ordered' => 10, 'qty_reserved' => 0, 'qty_delivered' => 0,
        'unit' => 'pcs', 'unit_price' => '150000', 'subtotal' => '1500000',
    ]);

    $result = app(ConfirmSalesOrder::class)->execute($so, $user->id);

    expect($result->status)->toBe('confirmed');
    $balance->refresh();
    expect((float) $balance->qty_reserved)->toBe(10.0);
});

test('ConfirmSalesOrder: rejects insufficient stock', function () {
    ['user' => $user, 'customer' => $customer, 'warehouse' => $warehouse, 'product' => $product] = salesSetup();

    $so = SalesOrder::create([
        'number' => 'SO-002', 'order_date' => now(),
        'customer_id' => $customer->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => 0, 'status' => 'draft', 'created_by' => $user->id,
    ]);
    SalesOrderLine::create([
        'sales_order_id' => $so->id, 'product_id' => $product->id,
        'qty_ordered' => 999, 'qty_reserved' => 0, 'qty_delivered' => 0,
        'unit' => 'pcs', 'unit_price' => '150000', 'subtotal' => '0',
    ]);

    expect(fn () => app(ConfirmSalesOrder::class)->execute($so, $user->id))
        ->toThrow(RuntimeException::class, 'Stok tidak cukup');
});

test('Full flow: SO → DO → Invoice → Payment', function () {
    Event::fake([DeliveryPosted::class, InvoicePosted::class, PaymentPosted::class]);

    ['user' => $user, 'customer' => $customer, 'warehouse' => $warehouse, 'product' => $product, 'balance' => $balance] = salesSetup();

    // Seed stock_movements so StockLedger.deliver() can find a record
    \App\Models\StockMovement::create([
        'product_id'       => $product->id,
        'warehouse_id'     => $warehouse->id,
        'type'             => 'in',
        'qty_change'       => '50',
        'unit_cost'        => '100000.0000',
        'value_change'     => '5000000.00',
        'qty_after'        => '50',
        'value_after'      => '5000000.00',
        'avg_cost_after'   => '100000.0000',
        'source_type'      => 'goods_receipt',
        'source_id'        => 1,
        'occurred_at'      => now(),
        'created_by'       => $user->id,
    ]);

    // 1) Create + confirm SO
    $so = SalesOrder::create([
        'number' => 'SO-003', 'order_date' => now(),
        'customer_id' => $customer->id, 'warehouse_id' => $warehouse->id,
        'total_amount' => '1500000', 'status' => 'draft', 'created_by' => $user->id,
    ]);
    $soLine = SalesOrderLine::create([
        'sales_order_id' => $so->id, 'product_id' => $product->id,
        'qty_ordered' => 10, 'qty_reserved' => 0, 'qty_delivered' => 0,
        'unit' => 'pcs', 'unit_price' => '150000', 'subtotal' => '1500000',
    ]);
    app(ConfirmSalesOrder::class)->execute($so, $user->id);

    // 2) Create + post Delivery
    $delivery = Delivery::create([
        'number' => 'DO-001', 'delivery_date' => now(),
        'sales_order_id' => $so->id, 'customer_id' => $customer->id,
        'warehouse_id' => $warehouse->id, 'status' => 'draft', 'created_by' => $user->id,
    ]);
    DeliveryLine::create([
        'delivery_id'         => $delivery->id,
        'sales_order_item_id' => $soLine->id,
        'product_id'          => $product->id,
        'qty'                 => 10,
        'unit'                => 'pcs',
        'unit_cost'           => 0,
        'line_cost'           => 0,
        'subtotal'            => 0,
    ]);

    $delivery = app(PostDelivery::class)->execute($delivery, $user->id);

    expect($delivery->status)->toBe('posted');
    Event::assertDispatched(DeliveryPosted::class);

    $balance->refresh();
    expect((float) $balance->on_hand)->toBe(40.0);

    // 3) Create + post Invoice
    $invoice = Invoice::create([
        'number' => 'INV-001', 'invoice_date' => now(), 'due_date' => now()->addDays(30),
        'delivery_id' => $delivery->id, 'sales_order_id' => $so->id, 'customer_id' => $customer->id,
        'total_amount' => '1500000', 'paid_amount' => '0',
        'status' => 'draft', 'created_by' => $user->id,
    ]);
    $invoice = app(PostInvoice::class)->execute($invoice, $user->id);

    expect($invoice->status)->toBe('open');
    Event::assertDispatched(InvoicePosted::class);

    // 4) Create + post Payment (full)
    $payment = CustomerPayment::create([
        'number' => 'PAY-001', 'payment_date' => now(),
        'invoice_id' => $invoice->id, 'customer_id' => $customer->id,
        'account_id' => test()->cashAccount->id,
        'amount' => '1500000', 'method' => 'transfer', 'status' => 'draft', 'created_by' => $user->id,
    ]);
    $payment = app(PostCustomerPayment::class)->execute($payment, $user->id);

    expect($payment->status)->toBe('posted');
    Event::assertDispatched(PaymentPosted::class);

    $invoice->refresh();
    expect((float) $invoice->paid_amount)->toBe(1500000.0)
        ->and($invoice->status)->toBe('paid');
});

test('PostCustomerPayment: overpayment rejected', function () {
    ['user' => $user, 'customer' => $customer] = salesSetup();

    $invoice = Invoice::create([
        'number' => 'INV-002', 'invoice_date' => now(), 'due_date' => now()->addDays(30),
        'customer_id' => $customer->id, 'total_amount' => '100000',
        'paid_amount' => '0', 'status' => 'open', 'created_by' => $user->id,
    ]);
    $payment = CustomerPayment::create([
        'number' => 'PAY-002', 'payment_date' => now(),
        'invoice_id' => $invoice->id, 'customer_id' => $customer->id,
        'account_id' => test()->cashAccount->id,
        'amount' => '999999', 'method' => 'cash', 'status' => 'draft', 'created_by' => $user->id,
    ]);

    expect(fn () => app(PostCustomerPayment::class)->execute($payment, $user->id))
        ->toThrow(RuntimeException::class, 'melebihi');
});

test('CloseSalesOrder: releases unreserved stock', function () {
    extract(salesSetup());
    $so = SalesOrder::create(['number' => 'SO-CLOSE', 'customer_id' => $customer->id, 'warehouse_id' => $warehouse->id, 'order_date' => now(), 'total_amount' => '15000', 'status' => 'draft', 'created_by' => $user->id]);
    $so->lines()->create(['product_id' => $product->id, 'qty_ordered' => '10.000', 'qty_reserved' => '0', 'qty_delivered' => '0', 'unit' => 'pcs', 'unit_price' => '1500.00', 'subtotal' => '15000.00']);
    
    app(ConfirmSalesOrder::class)->execute($so->fresh(), $user->id);
    
    $reservedBefore = \App\Models\StockBalance::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->value('qty_reserved');
    $so = app(\App\Domain\Sales\Actions\CloseSalesOrder::class)->execute($so->fresh(), $user->id);
    
    expect($so->status)->toBe('cancelled')
        ->and($so->cancelled_by)->toBe($user->id);
    $reservedAfter = \App\Models\StockBalance::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->value('qty_reserved');
    expect(bccomp($reservedAfter, bcsub($reservedBefore, '10.000', 4), 4))->toBe(0);
});
