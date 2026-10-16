<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add qty_ordered/qty_received tracking columns to line tables.
 * Rename generic 'qty' to specific names per table purpose.
 */
return new class extends Migration
{
    public function up(): void
    {
        // purchase_order_lines: rename qty → qty_ordered, add qty_received
        Schema::table('purchase_order_lines', function (Blueprint $table) {
            $table->renameColumn('qty', 'qty_ordered');
        });
        Schema::table('purchase_order_lines', function (Blueprint $table) {
            $table->decimal('qty_received', 18, 4)->default(0)->after('qty_ordered');
        });

        // goods_receipt_lines: rename qty → qty_received, add purchase_order_item_id
        Schema::table('goods_receipt_lines', function (Blueprint $table) {
            $table->renameColumn('qty', 'qty_received');
        });
        Schema::table('goods_receipt_lines', function (Blueprint $table) {
            $table->foreignId('purchase_order_item_id')->nullable()->after('goods_receipt_id')
                ->constrained('purchase_order_lines')->nullOnDelete();
        });

        // vendor_bill_lines: already OK (no qty tracking needed, bills copy from GR)

        // sales_order_lines: rename qty → qty_ordered, add qty_reserved, qty_delivered
        Schema::table('sales_order_lines', function (Blueprint $table) {
            $table->renameColumn('qty', 'qty_ordered');
        });
        Schema::table('sales_order_lines', function (Blueprint $table) {
            $table->decimal('qty_reserved', 18, 4)->default(0)->after('qty_ordered');
            $table->decimal('qty_delivered', 18, 4)->default(0)->after('qty_reserved');
        });

        // delivery_lines: rename qty → qty, add sales_order_item_id
        Schema::table('delivery_lines', function (Blueprint $table) {
            $table->foreignId('sales_order_item_id')->nullable()->after('delivery_id')
                ->constrained('sales_order_lines')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('delivery_lines', function (Blueprint $table) {
            $table->dropForeign(['sales_order_item_id']);
            $table->dropColumn('sales_order_item_id');
        });

        Schema::table('sales_order_lines', function (Blueprint $table) {
            $table->dropColumn(['qty_reserved', 'qty_delivered']);
        });
        Schema::table('sales_order_lines', function (Blueprint $table) {
            $table->renameColumn('qty_ordered', 'qty');
        });

        Schema::table('goods_receipt_lines', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_item_id']);
            $table->dropColumn('purchase_order_item_id');
        });
        Schema::table('goods_receipt_lines', function (Blueprint $table) {
            $table->renameColumn('qty_received', 'qty');
        });

        Schema::table('purchase_order_lines', function (Blueprint $table) {
            $table->dropColumn('qty_received');
        });
        Schema::table('purchase_order_lines', function (Blueprint $table) {
            $table->renameColumn('qty_ordered', 'qty');
        });
    }
};
