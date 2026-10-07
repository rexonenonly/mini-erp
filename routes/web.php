<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

Route::get('/master-data', fn() => view('master-data'));
Route::get('/inventory', fn() => view('inventory'));
Route::get('/purchasing', fn() => view('purchasing'));
Route::get('/sales', fn() => view('sales'));
Route::get('/accounting', fn() => view('accounting'));
