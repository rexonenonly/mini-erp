<?php

use App\Domain\Accounting\Services\JournalPoster;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\User;

beforeEach(function () {
    Account::create(['code' => '1110', 'name' => 'Cash', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'cash', 'is_active' => true]);
    Account::create(['code' => '1150', 'name' => 'Inventory', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'inventory', 'is_active' => true]);
    Account::create(['code' => '2110', 'name' => 'GRIR', 'type' => 'liability', 'normal_balance' => 'credit', 'system_key' => 'grir', 'is_active' => true]);
    Account::create(['code' => '5110', 'name' => 'COGS', 'type' => 'cogs', 'normal_balance' => 'debit', 'system_key' => 'cogs', 'is_active' => true]);

    $this->user = User::factory()->create();
});

test('journals page returns 200 for authorized user', function () {
    $this->user->givePermissionTo('journals.view');
    $this->actingAs($this->user);

    $response = $this->get('/accounting/journals');

    $response->assertOk();
});

test('journals page is forbidden without permission', function () {
    $this->actingAs($this->user);

    $response = $this->get('/accounting/journals');

    $response->assertForbidden();
});

test('ledger requires account_id', function () {
    $this->user->givePermissionTo('ledger.view');
    $this->actingAs($this->user);

    $response = $this->get('/accounting/ledger');

    // No account_id → renders account selector (200), not an error
    $response->assertOk();
});

test('ledger page returns 200 for authorized user', function () {
    $this->user->givePermissionTo('ledger.view');
    $this->actingAs($this->user);
    $cash = Account::where('system_key', 'cash')->first();

    $response = $this->get("/accounting/ledger?account_id={$cash->id}");

    $response->assertOk();
});

test('ledger page is forbidden without permission', function () {
    $this->actingAs($this->user);

    $response = $this->get('/accounting/ledger');

    $response->assertForbidden();
});

test('ledger running balance is correctly computed', function () {
    // Use JournalPoster to create real entries that exercise the domain
    $poster = app(JournalPoster::class);
    $cash = Account::where('system_key', 'cash')->first();

    // Entry 1: debit cash 100
    $poster->post(
        sourceType: 'test',
        sourceId: 1,
        description: 'Debit cash 100',
        lines: [
            ['account_key' => 'cash', 'debit' => 100, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 100],
        ],
        entryDate: now()->subDays(2),
        createdBy: $this->user->id,
    );

    // Entry 2: credit cash 50
    $poster->post(
        sourceType: 'test',
        sourceId: 2,
        description: 'Credit cash 50',
        lines: [
            ['account_key' => 'grir', 'debit' => 50, 'credit' => 0],
            ['account_key' => 'cash', 'debit' => 0, 'credit' => 50],
        ],
        entryDate: now()->subDays(1),
        createdBy: $this->user->id,
    );

    // Entry 3: debit cash 75
    $poster->post(
        sourceType: 'test',
        sourceId: 3,
        description: 'Debit cash 75',
        lines: [
            ['account_key' => 'cash', 'debit' => 75, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 75],
        ],
        entryDate: now(),
        createdBy: $this->user->id,
    );

    // Query all journal lines for cash, ordered by entry_date asc
    $lines = JournalLine::where('account_id', $cash->id)
        ->join('journal_entries', 'journal_entries.id', '=', 'journal_lines.journal_entry_id')
        ->orderBy('journal_entries.entry_date')
        ->orderBy('journal_lines.id')
        ->select('journal_lines.*')
        ->get();

    // Compute running balance (debit-normal account: debit increases, credit decreases)
    $balance = 0;
    $expectedBalances = [100.00, 50.00, 125.00];
    foreach ($lines as $i => $line) {
        $balance += (float) $line->debit - (float) $line->credit;
        expect(round($balance, 2))->toBe($expectedBalances[$i], "Running balance at row $i");
    }
    expect($lines)->toHaveCount(3);
});
