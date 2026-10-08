<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\RoleController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated pages
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

    // Master Data
    Route::view('/master-data/products', 'master-data.products')->name('master-data.products')->middleware('can:products.view');
    Route::view('/master-data/warehouses', 'master-data.warehouses')->name('master-data.warehouses')->middleware('can:warehouses.view');
    Route::view('/master-data/partners', 'master-data.partners')->name('master-data.partners')->middleware('can:partners.view');
    Route::view('/master-data/accounts', 'master-data.accounts')->name('master-data.accounts')->middleware('can:accounts.view');

    // Inventory
    Route::view('/inventory/stock', 'inventory.stock')->name('inventory.stock')->middleware('can:stock.view');
    Route::view('/inventory/opname', 'inventory.opname')->name('inventory.opname')->middleware('can:stock-opnames.view');
    Route::view('/inventory/transfers', 'inventory.transfers')->name('inventory.transfers')->middleware('can:stock-transfers.view');

    // Purchasing
    Route::view('/purchasing/orders', 'purchasing.orders')->name('purchasing.orders')->middleware('can:purchase-orders.view');
    Route::view('/purchasing/receipts', 'purchasing.receipts')->name('purchasing.receipts')->middleware('can:goods-receipts.view');
    Route::view('/purchasing/bills', 'purchasing.bills')->name('purchasing.bills')->middleware('can:vendor-bills.view');
    Route::view('/purchasing/payments', 'purchasing.payments')->name('purchasing.payments')->middleware('can:supplier-payments.view');

    // Sales
    Route::view('/sales/orders', 'sales.orders')->name('sales.orders')->middleware('can:sales-orders.view');
    Route::view('/sales/deliveries', 'sales.deliveries')->name('sales.deliveries')->middleware('can:deliveries.view');
    Route::view('/sales/invoices', 'sales.invoices')->name('sales.invoices')->middleware('can:invoices.view');
    Route::view('/sales/payments', 'sales.payments')->name('sales.payments')->middleware('can:customer-payments.view');

    // Accounting
    Route::view('/accounting/journals', 'accounting.journals')->name('accounting.journals')->middleware('can:journals.view');
    Route::view('/accounting/ledger', 'accounting.ledger')->name('accounting.ledger')->middleware('can:ledger.view');
    Route::view('/accounting/periods', 'accounting.periods')->name('accounting.periods')->middleware('can:periods.view');

    // Laporan
    Route::view('/reports/trial-balance', 'reports.trial-balance')->name('reports.trial-balance')->middleware('can:trial-balance.view');
    Route::view('/reports/income-statement', 'reports.income-statement')->name('reports.income-statement')->middleware('can:income-statement.view');
    Route::view('/reports/aging', 'reports.aging')->name('reports.aging')->middleware('can:reports.aging.view');
    Route::view('/reports/inventory-valuation', 'reports.inventory-valuation')->name('reports.inventory-valuation')->middleware('can:inventory-valuation.view');

    // Sistem — Pengguna & Role
    Route::get('/system/users', [UserController::class, 'index'])->name('system.users')->middleware('can:users.view');
    Route::get('/system/users/create', [UserController::class, 'create'])->name('system.users.create')->middleware('can:users.create');
    Route::post('/system/users', [UserController::class, 'store'])->name('system.users.store')->middleware('can:users.create');
    Route::get('/system/users/{user}/edit', [UserController::class, 'edit'])->name('system.users.edit')->middleware('can:users.update');
    Route::put('/system/users/{user}', [UserController::class, 'update'])->name('system.users.update')->middleware('can:users.update');
    Route::patch('/system/users/{user}/status', [UserController::class, 'toggleStatus'])->name('system.users.status')->middleware('can:users.update');

    Route::get('/system/roles', [RoleController::class, 'index'])->name('system.roles')->middleware('can:roles.view');
    Route::get('/system/roles/create', [RoleController::class, 'create'])->name('system.roles.create')->middleware('can:roles.create');
    Route::post('/system/roles', [RoleController::class, 'store'])->name('system.roles.store')->middleware('can:roles.create');
    Route::get('/system/roles/{role}/edit', [RoleController::class, 'edit'])->name('system.roles.edit')->middleware('can:roles.update');
    Route::put('/system/roles/{role}', [RoleController::class, 'update'])->name('system.roles.update')->middleware('can:roles.update');
    Route::delete('/system/roles/{role}', [RoleController::class, 'destroy'])->name('system.roles.destroy')->middleware('can:roles.update');

    // Legacy module roots: honor ?tab=, else land on first page
    Route::get('/master-data', fn() => redirect(request('tab') ? '/master-data/' . request('tab') : '/master-data/products'));
    Route::get('/inventory', fn() => redirect(request('tab') ? '/inventory/' . request('tab') : '/inventory/stock'));
    Route::get('/purchasing', fn() => redirect(request('tab') ? '/purchasing/' . request('tab') : '/purchasing/orders'));
    Route::get('/sales', fn() => redirect(request('tab') ? '/sales/' . request('tab') : '/sales/orders'));
    Route::get('/accounting', fn() => redirect(request('tab') ? '/accounting/' . request('tab') : '/accounting/journals'));
    Route::get('/reports', function () {
        $tab = request('tab', 'trial-balance');
        $map = [
            'neraca-saldo'        => 'trial-balance',
            'laba-rugi'           => 'income-statement',
            'umur-piutang-hutang' => 'aging',
            'nilai-persediaan'    => 'inventory-valuation',
        ];
        return redirect('/reports/' . ($map[$tab] ?? $tab));
    });
});

// Legacy redirects for guests (outside auth, redirect to login via auth middleware would handle, but keep for completeness)
