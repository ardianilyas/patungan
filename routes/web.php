<?php

use App\Http\Controllers\Dashboard\TopupControler as DashboardTopupController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\TopupController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   Route::get('/topup', [TopupController::class, 'index'])->name('topup.index');
   Route::post('/topup', [TopupController::class, 'store'])->name('topup.store');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
   Route::get('/topup', [DashboardTopupController::class, 'index'])->name('topup.index');
   Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

// Webhook routes
Route::post('/topup-webhook', [TopupController::class, 'handleWebhook'])->name('topup.webhook');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
