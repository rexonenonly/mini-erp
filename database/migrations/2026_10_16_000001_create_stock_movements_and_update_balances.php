<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Append-only stock ledger
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->string('type', 20); // receipt, delivery, adjustment, transfer_in, transfer_out
            $table->boolean('is_reversal')->default(false);
            $table->foreignId('reverses_id')->nullable()->constrained('stock_movements')->nullOnDelete();
            $table->decimal('qty_change', 18, 4);       // signed: + in, - out
            $table->decimal('unit_cost', 18, 4);
            $table->decimal('value_change', 18, 2);     // signed, exact
            $table->decimal('qty_after', 18, 4);        // snapshot after
            $table->decimal('value_after', 18, 2);      // snapshot after
            $table->decimal('avg_cost_after', 18, 4);
            $table->string('source_type', 30);          // goods_receipt, delivery, stock_opname, stock_transfer
            $table->unsignedBigInteger('source_id');
            $table->timestamp('occurred_at');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
            // no updated_at — append-only

            $table->index(['product_id', 'warehouse_id', 'occurred_at', 'id']);
            $table->index(['source_type', 'source_id']);
        });

        // Add qty_reserved and total_value to stock_balances (keep on_hand for compatibility)
        Schema::table('stock_balances', function (Blueprint $table) {
            $table->decimal('qty_reserved', 18, 4)->default(0)->after('on_hand');
            $table->decimal('total_value', 18, 2)->default(0)->after('qty_reserved');
            $table->decimal('avg_cost', 18, 4)->default(0)->after('total_value');
        });

        // Forbid UPDATE and DELETE on stock_movements (append-only)
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION forbid_stock_movement_mutation()
            RETURNS trigger LANGUAGE plpgsql AS $$
            BEGIN
                RAISE EXCEPTION 'stock_movements is append-only (% denied)', TG_OP;
            END;
            $$;

            CREATE TRIGGER trg_stock_movements_immutable
                BEFORE UPDATE OR DELETE ON stock_movements
                FOR EACH ROW EXECUTE FUNCTION forbid_stock_movement_mutation();
        SQL);

        // CHECK constraint: qty_change must not be zero
        DB::unprepared(
            'ALTER TABLE stock_movements ADD CONSTRAINT chk_movements_qty CHECK (qty_change <> 0)'
        );

        // CHECK constraints on stock_balances
        DB::unprepared(<<<'SQL'
            ALTER TABLE stock_balances
                ADD CONSTRAINT chk_balances_qty   CHECK (on_hand >= 0 AND qty_reserved >= 0 AND qty_reserved <= on_hand),
                ADD CONSTRAINT chk_balances_value CHECK (total_value >= 0 AND (on_hand > 0 OR total_value = 0));
        SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stock_movements_immutable ON stock_movements');
        DB::unprepared('DROP FUNCTION IF EXISTS forbid_stock_movement_mutation');

        Schema::table('stock_balances', function (Blueprint $table) {
            $table->dropColumn(['qty_reserved', 'total_value', 'avg_cost']);
        });

        Schema::dropIfExists('stock_movements');
    }
};
