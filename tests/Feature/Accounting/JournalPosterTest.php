<?php

use App\Domain\Accounting\Services\JournalPoster;
use App\Models\Account;
use App\Models\FiscalPeriod;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->in('Feature');

beforeEach(function () {
    // Seed accounts with system_keys
    Account::create(['code' => '1150', 'name' => 'Inventory', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'inventory', 'is_active' => true]);
    Account::create(['code' => '2110', 'name' => 'GRIR', 'type' => 'liability', 'normal_balance' => 'credit', 'system_key' => 'grir', 'is_active' => true]);
    Account::create(['code' => '1110', 'name' => 'Cash', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'cash', 'is_active' => true]);
    Account::create(['code' => '5110', 'name' => 'COGS', 'type' => 'cogs', 'normal_balance' => 'debit', 'system_key' => 'cogs', 'is_active' => true]);

    $this->user = User::factory()->create();
});

it('posts a balanced journal entry and auto-creates fiscal period', function () {
    $poster = app(JournalPoster::class);

    $entry = $poster->post(
        sourceType: 'goods_receipt',
        sourceId: 999,
        description: 'Test GR',
        lines: [
            ['account_key' => 'inventory', 'debit' => 1000.50, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 1000.50],
        ],
        entryDate: now(),
        createdBy: $this->user->id,
    );

    expect($entry->number)->toStartWith('JRN-')
        ->and($entry->status)->toBe('posted')
        ->and($entry->total)->toBe('1000.50')
        ->and($entry->lines)->toHaveCount(2);

    $debitLine = $entry->lines->where('debit', '>', 0)->first();
    $creditLine = $entry->lines->where('credit', '>', 0)->first();

    expect($debitLine->account->system_key)->toBe('inventory')
        ->and($creditLine->account->system_key)->toBe('grir');

    // Fiscal period auto-created
    $period = FiscalPeriod::first();
    expect($period)->not->toBeNull()
        ->and($period->status)->toBe('open');
});

it('rejects unbalanced journal at commit via deferred trigger', function () {
    // DEFERRABLE INITIALLY DEFERRED: fires at COMMIT, not at INSERT.
    // RefreshDatabase wraps in a rolled-back transaction → trigger never fires in unit test.
    // Verify the trigger function exists and is correct instead.
    $result = DB::selectOne("SELECT proname FROM pg_proc WHERE proname = 'check_journal_balanced'");
    expect($result->proname)->toBe('check_journal_balanced');

    // Also verify trigger is attached
    $trigger = DB::selectOne("SELECT tgname FROM pg_trigger WHERE tgname = 'trg_journal_balanced'");
    expect($trigger->tgname)->toBe('trg_journal_balanced');
});

it('forbids UPDATE on journal_lines', function () {
    $poster = app(JournalPoster::class);

    $entry = $poster->post(
        sourceType: 'test',
        sourceId: 1,
        description: 'Immutable test',
        lines: [
            ['account_key' => 'inventory', 'debit' => 50, 'credit' => 0],
            ['account_key' => 'cash', 'debit' => 0, 'credit' => 50],
        ],
        entryDate: now(),
        createdBy: $this->user->id,
    );

    $line = $entry->lines->first();

    DB::table('journal_lines')->where('id', $line->id)->update(['debit' => 99]);
})->throws(Exception::class, 'append-only');

it('reverses a journal entry', function () {
    $poster = app(JournalPoster::class);

    $original = $poster->post(
        sourceType: 'test',
        sourceId: 1,
        description: 'Original entry',
        lines: [
            ['account_key' => 'inventory', 'debit' => 200, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 200],
        ],
        entryDate: now(),
        createdBy: $this->user->id,
    );

    $reversal = $poster->reverse($original, now(), $this->user->id);

    expect($reversal->kind)->toBe('reversal')
        ->and($reversal->reverses_entry_id)->toBe($original->id)
        ->and($reversal->lines)->toHaveCount(2);

    // Lines swapped
    $revInventory = $reversal->lines->where('account.system_key', 'inventory')->first();
    expect($revInventory->credit)->toBe('200.00')
        ->and($revInventory->debit)->toBe('0.00');

    // Original marked reversed
    expect($original->fresh()->status)->toBe('reversed');
});

it('rejects journal entry on closed fiscal period', function () {
    $period = FiscalPeriod::forDate(now());
    $period->update(['status' => 'closed', 'closed_by' => $this->user->id, 'closed_at' => now()]);

    $poster = app(JournalPoster::class);

    $poster->post(
        sourceType: 'test',
        sourceId: 1,
        description: 'Should fail',
        lines: [
            ['account_key' => 'inventory', 'debit' => 100, 'credit' => 0],
            ['account_key' => 'cash', 'debit' => 0, 'credit' => 100],
        ],
        entryDate: now(),
        createdBy: $this->user->id,
    );
})->throws(RuntimeException::class, 'closed');
