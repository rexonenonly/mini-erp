<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

Route::get('/master-data/products', fn() => view('master-data.products'));
Route::get('/master-data/warehouses', fn() => view('master-data.warehouses'));
Route::get('/master-data/partners', fn() => view('master-data.partners'));
Route::get('/master-data/accounts', fn() => view('master-data.accounts'));
