<?php

use App\Models\JournalEntry;
use App\Models\StockBalance;
use App\Models\StockMovement;
use App\Models\Invoice;
use App\Models\VendorBill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('I-1: all journal entries are balanced (debit = credit, min 2 lines)', function () {
    $unbalanced = JournalEntry::query()
        ->whereRaw('(SELECT COALESCE(SUM(debit), 0) FROM journal_entry_lines WHERE journal_entry_id = journal_entries.id) != (SELECT COALESCE(SUM(credit), 0) FROM journal_entry_lines WHERE journal_entry_id = journal_entries.id)')
        ->orWhereRaw('(SELECT COUNT(*) FROM journal_entry_lines WHERE journal_entry_id = journal_entries.id) < 2')
        ->get();

    expect($unbalanced)->toBeEmpty();
})->skip('requires seeded data');

test('I-5: stock_balances = sum(stock_movements)', function () {
    $mismatches = StockBalance::query()
        ->whereRaw('on_hand != (SELECT COALESCE(SUM(qty), 0) FROM stock_movements WHERE product_id = stock_balances.product_id AND warehouse_id = stock_balances.warehouse_id)')
        ->get();

    expect($mismatches)->toBeEmpty();
})->skip('requires seeded data');

test('I-6: stock not negative, reservation <= on_hand', function () {
    $violations = StockBalance::query()
        ->where('on_hand', '<', 0)
        ->orWhereRaw('qty_reserved > on_hand')
        ->get();

    expect($violations)->toBeEmpty();
})->skip('requires seeded data');

test('I-9: payment amount <= bill/invoice total', function () {
    $overpaidBills = VendorBill::query()
        ->whereRaw('paid_amount > total_amount')
        ->get();

    $overpaidInvoices = Invoice::query()
        ->whereRaw('paid_amount > total_amount')
        ->get();

    expect($overpaidBills)->toBeEmpty()
        ->and($overpaidInvoices)->toBeEmpty();
})->skip('requires seeded data');
