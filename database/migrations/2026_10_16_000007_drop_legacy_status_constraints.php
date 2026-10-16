<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Drop legacy status CHECK constraints added by original migration
 * that now conflict with our new chk_* constraints.
 * Also fix vendor_bills default status from 'open' → 'draft'.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE purchase_orders DROP CONSTRAINT IF EXISTS purchase_orders_status_check');
        DB::statement('ALTER TABLE goods_receipts DROP CONSTRAINT IF EXISTS goods_receipts_status_check');
        DB::statement('ALTER TABLE vendor_bills DROP CONSTRAINT IF EXISTS vendor_bills_status_check');
        DB::statement('ALTER TABLE supplier_payments DROP CONSTRAINT IF EXISTS supplier_payments_status_check');
        DB::statement('ALTER TABLE supplier_payments DROP CONSTRAINT IF EXISTS supplier_payments_method_check');

        // Fix default: vendor_bills was set to 'open' but new workflow starts at 'draft'
        DB::statement("ALTER TABLE vendor_bills ALTER COLUMN status SET DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Omit: restoring old constraints not worth it, schema upgrade is one-way
    }
};
