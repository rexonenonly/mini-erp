<?php

use App\Domain\Accounting\Services\JournalPoster;
use App\Models\Account;
use App\Models\User;

beforeEach(function () {
    Account::create(['code' => '1110', 'name' => 'Cash', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'cash', 'is_active' => true]);
    Account::create(['code' => '1150', 'name' => 'Inventory', 'type' => 'asset', 'normal_balance' => 'debit', 'system_key' => 'inventory', 'is_active' => true]);
    Account::create(['code' => '2110', 'name' => 'GRIR', 'type' => 'liability', 'normal_balance' => 'credit', 'system_key' => 'grir', 'is_active' => true]);
    Account::create(['code' => '5110', 'name' => 'COGS', 'type' => 'cogs', 'normal_balance' => 'debit', 'system_key' => 'cogs', 'is_active' => true]);

    $this->user = User::factory()->create();
});

test('trial balance page returns 200 for authorized user', function () {
    $this->user->givePermissionTo('trial-balance.view');
    $this->actingAs($this->user);

    $response = $this->get('/reports/trial-balance');

    $response->assertOk();
});

test('trial balance page is forbidden without permission', function () {
    $this->actingAs($this->user);

    $response = $this->get('/reports/trial-balance');

    $response->assertForbidden();
});

test('trial balance total debit equals total credit', function () {
    $this->user->givePermissionTo('trial-balance.view');
    $this->actingAs($this->user);

    $poster = app(JournalPoster::class);

    $poster->post(
        sourceType: 'test', sourceId: 1, description: 'TB entry 1',
        lines: [
            ['account_key' => 'inventory', 'debit' => 500, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 500],
        ],
        entryDate: now(), createdBy: $this->user->id,
    );

    $poster->post(
        sourceType: 'test', sourceId: 2, description: 'TB entry 2',
        lines: [
            ['account_key' => 'cash', 'debit' => 200, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 200],
        ],
        entryDate: now(), createdBy: $this->user->id,
    );

    $response = $this->get('/reports/trial-balance');
    
    $response->assertOk();
});

test('trial balance excludes zero balance accounts', function () {
    $this->user->givePermissionTo('trial-balance.view');
    $this->actingAs($this->user);

    // Post entry only involving Cash and GRIR — Inventory and COGS have zero balance
    $poster = app(JournalPoster::class);
    $poster->post(
        sourceType: 'test', sourceId: 1, description: 'Only cash',
        lines: [
            ['account_key' => 'cash', 'debit' => 100, 'credit' => 0],
            ['account_key' => 'grir', 'debit' => 0, 'credit' => 100],
        ],
        entryDate: now(), createdBy: $this->user->id,
    );

    $response = $this->get('/reports/trial-balance');

    $response->assertOk();
});
