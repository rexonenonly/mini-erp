<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. fiscal_periods
        Schema::create('fiscal_periods', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 10)->default('open'); // open, closed
            $table->foreignId('closed_by')->nullable()->constrained('users');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month']);
        });

        // 2. ALTER accounts: add normal_balance, system_key, fix type enum → varchar with CHECK, remove balance
        DB::statement("ALTER TABLE accounts ALTER COLUMN type TYPE varchar(10)");
        DB::unprepared("ALTER TABLE accounts ADD CONSTRAINT chk_accounts_type CHECK (type IN ('asset','liability','equity','revenue','cogs','expense'))");
        
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('normal_balance', 6)->default('debit')->after('type');
            $table->string('system_key', 30)->nullable()->unique()->after('normal_balance');
            $table->dropColumn('balance'); // computed from journals
        });

        // 3. ALTER journal_entries: add fiscal_period_id, kind, reverses_entry_id, total, drop posted_at/softDeletes, fix status
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn(['posted_at', 'deleted_at']); // no softDeletes, no posted_at
        });

        DB::statement("ALTER TABLE journal_entries ALTER COLUMN status TYPE varchar(10)");
        DB::statement("ALTER TABLE journal_entries ALTER COLUMN status DROP DEFAULT");

        Schema::table('journal_entries', function (Blueprint $table) {
            $table->foreignId('fiscal_period_id')->after('entry_date')->constrained();
            $table->string('kind', 10)->default('posting')->after('status'); // posting, reversal
            $table->foreignId('reverses_entry_id')->nullable()->after('kind')->constrained('journal_entries')->nullOnDelete();
            $table->decimal('total', 18, 2)->default(0)->after('description'); // debit == credit
        });

        DB::unprepared("ALTER TABLE journal_entries ADD CONSTRAINT chk_entries_status CHECK (status IN ('posted','reversed'))");

        // 4. ALTER journal_lines: add partner_id, description
        Schema::table('journal_lines', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('account_id')->constrained();
            $table->string('description')->nullable()->after('credit');
            $table->dropColumn('memo'); // replaced by description
        });

        // 5. Triggers: forbid mutation on journal_lines
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION forbid_journal_line_mutation()
            RETURNS trigger LANGUAGE plpgsql AS $$
            BEGIN
                RAISE EXCEPTION 'journal_lines is append-only (% denied)', TG_OP;
            END;
            $$;

            CREATE TRIGGER trg_journal_lines_immutable
                BEFORE UPDATE OR DELETE ON journal_lines
                FOR EACH ROW EXECUTE FUNCTION forbid_journal_line_mutation();
        SQL);

        // 6. Trigger: journal_entries guard (only posted→reversed, reject DELETE)
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION guard_journal_entry_mutation()
            RETURNS trigger LANGUAGE plpgsql AS $$
            BEGIN
                IF TG_OP = 'DELETE' THEN
                    RAISE EXCEPTION 'journal_entries cannot be deleted, reverse instead';
                END IF;
                -- UPDATE: only status change posted→reversed allowed
                IF OLD.status <> NEW.status THEN
                    IF OLD.status = 'posted' AND NEW.status = 'reversed' THEN
                        RETURN NEW;
                    ELSE
                        RAISE EXCEPTION 'Invalid status transition: % → %', OLD.status, NEW.status;
                    END IF;
                END IF;
                RETURN NEW;
            END;
            $$;

            CREATE TRIGGER trg_journal_entries_guard
                BEFORE UPDATE OR DELETE ON journal_entries
                FOR EACH ROW EXECUTE FUNCTION guard_journal_entry_mutation();
        SQL);

        // 7. Trigger: check_journal_balanced (DEFERRABLE, fires at commit)
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION check_journal_balanced()
            RETURNS trigger LANGUAGE plpgsql AS $$
            DECLARE
                line_count integer;
                debit_sum numeric;
                credit_sum numeric;
            BEGIN
                SELECT COUNT(*), COALESCE(SUM(debit), 0), COALESCE(SUM(credit), 0)
                INTO line_count, debit_sum, credit_sum
                FROM journal_lines
                WHERE journal_entry_id = NEW.id;

                IF line_count < 2 THEN
                    RAISE EXCEPTION 'Journal entry % must have at least 2 lines', NEW.number;
                END IF;

                IF debit_sum <> credit_sum THEN
                    RAISE EXCEPTION 'Journal entry % unbalanced: debit % <> credit %', NEW.number, debit_sum, credit_sum;
                END IF;

                RETURN NEW;
            END;
            $$;

            CREATE CONSTRAINT TRIGGER trg_journal_balanced
                AFTER INSERT OR UPDATE ON journal_entries
                DEFERRABLE INITIALLY DEFERRED
                FOR EACH ROW EXECUTE FUNCTION check_journal_balanced();
        SQL);

        // 8. Trigger: check_period_open (reject journal insert/update if period closed)
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE FUNCTION check_period_open()
            RETURNS trigger LANGUAGE plpgsql AS $$
            DECLARE
                period_status varchar(10);
            BEGIN
                SELECT status INTO period_status
                FROM fiscal_periods
                WHERE id = NEW.fiscal_period_id;

                IF period_status = 'closed' THEN
                    RAISE EXCEPTION 'Fiscal period is closed, cannot create or modify journal entries';
                END IF;

                RETURN NEW;
            END;
            $$;

            CREATE TRIGGER trg_period_guard
                BEFORE INSERT OR UPDATE ON journal_entries
                FOR EACH ROW EXECUTE FUNCTION check_period_open();
        SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_period_guard ON journal_entries');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_journal_balanced ON journal_entries');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_journal_entries_guard ON journal_entries');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_journal_lines_immutable ON journal_lines');
        DB::unprepared('DROP FUNCTION IF EXISTS check_period_open');
        DB::unprepared('DROP FUNCTION IF EXISTS check_journal_balanced');
        DB::unprepared('DROP FUNCTION IF EXISTS guard_journal_entry_mutation');
        DB::unprepared('DROP FUNCTION IF EXISTS forbid_journal_line_mutation');

        Schema::table('journal_lines', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
            $table->dropColumn(['partner_id', 'description']);
            $table->text('memo')->nullable();
        });

        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reverses_entry_id');
            $table->dropConstrainedForeignId('fiscal_period_id');
            $table->dropColumn(['kind', 'total']);
        });

        DB::statement("ALTER TABLE journal_entries ALTER COLUMN status TYPE varchar(20)");
        DB::statement("ALTER TABLE journal_entries ALTER COLUMN status SET DEFAULT 'draft'");

        Schema::table('journal_entries', function (Blueprint $table) {
            $table->timestamp('posted_at')->nullable();
            $table->softDeletes();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->decimal('balance', 15, 2)->default(0);
            $table->dropColumn(['system_key', 'normal_balance']);
        });

        DB::unprepared("ALTER TABLE accounts DROP CONSTRAINT IF EXISTS chk_accounts_type");
        DB::statement("ALTER TABLE accounts ALTER COLUMN type TYPE varchar(10)");

        Schema::dropIfExists('fiscal_periods');
    }
};
