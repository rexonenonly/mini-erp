<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add audit columns to sales tables. Drop legacy status constraints.
 * Add confirmed_by, cancelled_by/at on SO.
 * Add posted_by, reversed_by/at on deliveries, invoices, customer_payments.
 * Add sales_order_id + created_by on invoices. Add posted_at on customer_payments.
 */
return new class extends Migration
{
    public function up(): void
    {
        // sales_orders: audit columns + fix status constraint
        DB::statement('ALTER TABLE sales_orders DROP CONSTRAINT IF EXISTS sales_orders_status_check');
        DB::statement('ALTER TABLE sales_orders ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE sales_orders ADD CONSTRAINT chk_so_status CHECK (status IN ('draft','confirmed','partial','done','cancelled'))");

        Schema::table('sales_orders', function (Blueprint $table) {
            $table->foreignId('confirmed_by')->nullable()->after('confirmed_at')->constrained('users');
            $table->foreignId('cancelled_by')->nullable()->after('confirmed_by')->constrained('users');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
        });

        // deliveries: audit columns + fix status
        DB::statement('ALTER TABLE deliveries DROP CONSTRAINT IF EXISTS deliveries_status_check');
        DB::statement('ALTER TABLE deliveries ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE deliveries ADD CONSTRAINT chk_del_status CHECK (status IN ('draft','posted','reversed'))");

        Schema::table('deliveries', function (Blueprint $table) {
            $table->decimal('total_cost', 18, 2)->default(0)->after('total_value'); // HPP from ledger
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
        });

        // invoices: audit columns + fix status + add sales_order_id, created_by
        DB::statement('ALTER TABLE invoices DROP CONSTRAINT IF EXISTS invoices_status_check');
        DB::statement('ALTER TABLE invoices ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE invoices ADD CONSTRAINT chk_inv_status CHECK (status IN ('draft','open','partially_paid','paid','reversed'))");

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('sales_order_id')->nullable()->after('delivery_id')->constrained('sales_orders');
            $table->foreignId('created_by')->nullable()->after('notes')->constrained('users');
            $table->timestamp('posted_at')->nullable()->after('created_by');
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
        });

        // customer_payments: audit columns + fix status
        DB::statement('ALTER TABLE customer_payments DROP CONSTRAINT IF EXISTS customer_payments_status_check');
        DB::statement('ALTER TABLE customer_payments ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE customer_payments ADD CONSTRAINT chk_cp_status CHECK (status IN ('draft','posted','reversed'))");
        DB::statement('ALTER TABLE customer_payments ALTER COLUMN method TYPE varchar(20)');

        Schema::table('customer_payments', function (Blueprint $table) {
            $table->timestamp('posted_at')->nullable()->after('status');
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
            $table->string('reference', 100)->nullable()->after('notes');
        });

        // delivery_lines: add line_cost for HPP tracking (unit_cost already added in 000006)
        Schema::table('delivery_lines', function (Blueprint $table) {
            $table->decimal('line_cost', 18, 2)->default(0)->after('unit_cost');
        });
    }

    public function down(): void
    {
        Schema::table('delivery_lines', function (Blueprint $table) {
            $table->dropColumn('line_cost');
        });

        Schema::table('customer_payments', function (Blueprint $table) {
            $table->dropColumn(['posted_at', 'reversed_at', 'reference']);
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE customer_payments DROP CONSTRAINT IF EXISTS chk_cp_status');

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['posted_at', 'reversed_at']);
            $table->dropForeign(['sales_order_id']); $table->dropColumn('sales_order_id');
            $table->dropForeign(['created_by']); $table->dropColumn('created_by');
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE invoices DROP CONSTRAINT IF EXISTS chk_inv_status');

        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn(['total_cost', 'reversed_at']);
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE deliveries DROP CONSTRAINT IF EXISTS chk_del_status');

        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn(['cancelled_at']);
            $table->dropForeign(['confirmed_by']); $table->dropColumn('confirmed_by');
            $table->dropForeign(['cancelled_by']); $table->dropColumn('cancelled_by');
        });
        DB::statement('ALTER TABLE sales_orders DROP CONSTRAINT IF EXISTS chk_so_status');
    }
};
