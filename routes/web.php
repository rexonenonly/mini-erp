<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

// --- Master Data ---
Route::view('/master-data/products', 'master-data.products')->name('master-data.products');
Route::view('/master-data/warehouses', 'master-data.warehouses')->name('master-data.warehouses');
Route::view('/master-data/partners', 'master-data.partners')->name('master-data.partners');
Route::view('/master-data/accounts', 'master-data.accounts')->name('master-data.accounts');

// --- Inventory ---
Route::view('/inventory/stock', 'inventory.stock')->name('inventory.stock');
Route::view('/inventory/opname', 'inventory.opname')->name('inventory.opname');
Route::view('/inventory/transfers', 'inventory.transfers')->name('inventory.transfers');

// --- Purchasing ---
Route::view('/purchasing/orders', 'purchasing.orders')->name('purchasing.orders');
Route::view('/purchasing/receipts', 'purchasing.receipts')->name('purchasing.receipts');
Route::view('/purchasing/bills', 'purchasing.bills')->name('purchasing.bills');
Route::view('/purchasing/payments', 'purchasing.payments')->name('purchasing.payments');

// --- Sales ---
Route::view('/sales/orders', 'sales.orders')->name('sales.orders');
Route::view('/sales/deliveries', 'sales.deliveries')->name('sales.deliveries');
Route::view('/sales/invoices', 'sales.invoices')->name('sales.invoices');
Route::view('/sales/payments', 'sales.payments')->name('sales.payments');

// --- Accounting ---
Route::view('/accounting/journals', 'accounting.journals')->name('accounting.journals');
Route::view('/accounting/ledger', 'accounting.ledger')->name('accounting.ledger');
Route::view('/accounting/periods', 'accounting.periods')->name('accounting.periods');

// --- Laporan ---
Route::view('/reports/trial-balance', 'reports.trial-balance')->name('reports.trial-balance');
Route::view('/reports/income-statement', 'reports.income-statement')->name('reports.income-statement');
Route::view('/reports/aging', 'reports.aging')->name('reports.aging');
Route::view('/reports/inventory-valuation', 'reports.inventory-valuation')->name('reports.inventory-valuation');

// --- Legacy module roots: honor ?tab=, else land on first page ---
Route::get('/master-data', fn() => redirect(request('tab')
    ? '/master-data/' . request('tab') : '/master-data/products'));
Route::get('/inventory', fn() => redirect(request('tab')
    ? '/inventory/' . request('tab') : '/inventory/stock'));
Route::get('/purchasing', fn() => redirect(request('tab')
    ? '/purchasing/' . request('tab') : '/purchasing/orders'));
Route::get('/sales', fn() => redirect(request('tab')
    ? '/sales/' . request('tab') : '/sales/orders'));
Route::get('/accounting', fn() => redirect(request('tab')
    ? '/accounting/' . request('tab') : '/accounting/journals'));
Route::get('/reports', function () {
    // old report tabs used indonesian names; new pages are the english slugs
    $tab = request('tab', 'trial-balance');
    $map = [
        'neraca-saldo'        => 'trial-balance',
        'laba-rugi'           => 'income-statement',
        'umur-piutang-hutang' => 'aging',
        'nilai-persediaan'    => 'inventory-valuation',
    ];
    return redirect('/reports/' . ($map[$tab] ?? $tab));
});

