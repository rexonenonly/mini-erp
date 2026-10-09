<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('order_date');
            $table->foreignId('customer_id')->constrained('partners');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'partial', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('delivery_date');
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('partners');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->decimal('total_value', 15, 2)->default(0);
            $table->enum('status', ['draft', 'posted', 'reversed'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->foreignId('delivery_id')->nullable()->constrained('deliveries')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('partners');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['open', 'partial', 'paid', 'overdue', 'reversed'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->string('number', 40)->unique();
            $table->date('payment_date');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('partners');
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
        Schema::table('customer_payments', fn($t) => $t->dropForeign(['invoice_id', 'customer_id', 'created_by']));
        Schema::table('invoices', fn($t) => $t->dropForeign(['delivery_id', 'customer_id']));
        Schema::table('deliveries', fn($t) => $t->dropForeign(['sales_order_id', 'customer_id', 'warehouse_id', 'created_by']));
        Schema::table('sales_orders', fn($t) => $t->dropForeign(['customer_id', 'warehouse_id', 'created_by']));
        Schema::dropIfExists('customer_payments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('sales_orders');
    }
};