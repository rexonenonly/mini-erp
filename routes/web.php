<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

Route::get('/master-data', fn() => view('master-data.index'));
Route::get('/inventory', fn() => view('inventory.index'));
Route::get('/purchasing', fn() => view('purchasing.index'));
Route::get('/sales', fn() => view('sales.index'));
Route::get('/accounting', fn() => view('accounting.index'));
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
