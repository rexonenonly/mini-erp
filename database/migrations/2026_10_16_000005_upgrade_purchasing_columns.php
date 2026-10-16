<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add missing audit columns to purchasing tables.
 * Convert ENUM status to varchar + CHECK (easier to ALTER later).
 * Add supplier_ref on goods_receipts, payment term columns, etc.
 */
return new class extends Migration
{
    public function up(): void
    {
        // purchase_orders: add confirmed_by, cancelled_by/at, closed_by/at; fix status enum
        DB::statement('ALTER TABLE purchase_orders ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE purchase_orders ADD CONSTRAINT chk_po_status CHECK (status IN ('draft','confirmed','partial','done','cancelled'))");

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->foreignId('confirmed_by')->nullable()->after('confirmed_at')->constrained('users');
            $table->foreignId('cancelled_by')->nullable()->after('confirmed_by')->constrained('users');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
        });

        // goods_receipts: add posted_by, reversed_by/at, supplier_ref; fix status
        DB::statement('ALTER TABLE goods_receipts ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE goods_receipts ADD CONSTRAINT chk_gr_status CHECK (status IN ('draft','posted','reversed'))");

        Schema::table('goods_receipts', function (Blueprint $table) {
            $table->string('supplier_ref', 60)->nullable()->after('warehouse_id');
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
        });

        // vendor_bills: add created_by, posted_by, posted_at, reversed_by/at, supplier_bill_number, purchase_order_id; fix status
        DB::statement('ALTER TABLE vendor_bills ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE vendor_bills ADD CONSTRAINT chk_vb_status CHECK (status IN ('draft','open','partially_paid','paid','reversed'))");

        Schema::table('vendor_bills', function (Blueprint $table) {
            $table->string('supplier_bill_number', 60)->nullable()->after('number');
            $table->foreignId('purchase_order_id')->nullable()->after('receipt_id')->constrained('purchase_orders');
            $table->foreignId('created_by')->after('notes')->constrained('users');
            $table->timestamp('posted_at')->nullable()->after('created_by');
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
        });

        // supplier_payments: add posted_by, posted_at, reversed_by/at, account_id, idempotency_key; fix status
        DB::statement('ALTER TABLE supplier_payments ALTER COLUMN status TYPE varchar(20)');
        DB::statement("ALTER TABLE supplier_payments ADD CONSTRAINT chk_sp_status CHECK (status IN ('draft','posted','reversed'))");
        DB::statement('ALTER TABLE supplier_payments ALTER COLUMN method TYPE varchar(20)');

        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->timestamp('posted_at')->nullable()->after('status');
            $table->foreignId('posted_by')->nullable()->after('posted_at')->constrained('users');
            $table->foreignId('reversed_by')->nullable()->after('posted_by')->constrained('users');
            $table->timestamp('reversed_at')->nullable()->after('reversed_by');
            $table->string('reference', 100)->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_payments', function (Blueprint $table) {
            $table->dropColumn(['posted_at', 'reversed_at', 'reference']);
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE supplier_payments DROP CONSTRAINT IF EXISTS chk_sp_status');

        Schema::table('vendor_bills', function (Blueprint $table) {
            $table->dropColumn(['supplier_bill_number', 'posted_at', 'reversed_at']);
            $table->dropForeign(['purchase_order_id']); $table->dropColumn('purchase_order_id');
            $table->dropForeign(['created_by']); $table->dropColumn('created_by');
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE vendor_bills DROP CONSTRAINT IF EXISTS chk_vb_status');

        Schema::table('goods_receipts', function (Blueprint $table) {
            $table->dropColumn(['supplier_ref', 'posted_at', 'reversed_at']);
            $table->dropForeign(['posted_by']); $table->dropColumn('posted_by');
            $table->dropForeign(['reversed_by']); $table->dropColumn('reversed_by');
        });
        DB::statement('ALTER TABLE goods_receipts DROP CONSTRAINT IF EXISTS chk_gr_status');

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['cancelled_at']);
            $table->dropForeign(['confirmed_by']); $table->dropColumn('confirmed_by');
            $table->dropForeign(['cancelled_by']); $table->dropColumn('cancelled_by');
        });
        DB::statement('ALTER TABLE purchase_orders DROP CONSTRAINT IF EXISTS chk_po_status');
    }
};
