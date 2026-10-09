<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('order_date');
            $table->foreignId('supplier_id')->constrained('partners');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'partial', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('receipt_date');
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained('partners');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->decimal('total_value', 15, 2)->default(0);
            $table->enum('status', ['draft', 'posted', 'reversed'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vendor_bills', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('bill_date');
            $table->date('due_date')->nullable();
            $table->foreignId('receipt_id')->nullable()->constrained('goods_receipts')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained('partners');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['open', 'partial', 'paid', 'reversed'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('payment_date');
            $table->foreignId('bill_id')->nullable()->constrained('vendor_bills')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained('partners');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('method', ['transfer', 'cash', 'check'])->default('transfer');
            $table->enum('status', ['draft', 'posted', 'reversed'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::table('vendor_bills', function (Blueprint $table) {
            $table->dropForeign(['receipt_id']);
            $table->dropForeign(['supplier_id']);
        });
        Schema::table('goods_receipts', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['created_by']);
        });

        Schema::dropIfExists('supplier_payments');
        Schema::dropIfExists('vendor_bills');
        Schema::dropIfExists('goods_receipts');
        Schema::dropIfExists('purchase_orders');
    }
};