<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event', 30);               // created, updated, deleted, confirmed, posted, reversed, cancelled
            $table->string('auditable_type', 100);
            $table->unsignedBigInteger('auditable_id');
            $table->jsonb('old_values')->nullable();
            $table->jsonb('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            // no updated_at — append-only

            $table->index(['auditable_type', 'auditable_id']);
            $table->index('created_at');
        });

        // Forbid UPDATE and DELETE on audit_logs (append-only)
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION forbid_audit_log_mutation()
            RETURNS trigger LANGUAGE plpgsql AS $$
            BEGIN
                RAISE EXCEPTION 'audit_logs is append-only (% denied)', TG_OP;
            END;
            $$;

            CREATE TRIGGER trg_audit_logs_immutable
                BEFORE UPDATE OR DELETE ON audit_logs
                FOR EACH ROW EXECUTE FUNCTION forbid_audit_log_mutation();
        SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_audit_logs_immutable ON audit_logs');
        DB::unprepared('DROP FUNCTION IF EXISTS forbid_audit_log_mutation');
        Schema::dropIfExists('audit_logs');
    }
};
