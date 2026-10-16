<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('ALTER TABLE accounts DROP CONSTRAINT IF EXISTS accounts_type_check');
    }

    public function down(): void
    {
        // Constraint is re-created by down() in 2026_10_16_000002
    }
};
