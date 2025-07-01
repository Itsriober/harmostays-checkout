<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

Route::get('/paygate/callback/{booking_id}', [PaymentController::class, 'callback'])->name('paygate.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Home
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Generate Payment
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

    // Payment History
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    // Simulated Payment Page
    Route::get('/payments/simulate/{booking_id}', [PaymentController::class, 'simulate'])->name('payments.simulate');
    Route::post('/payments/simulate/{booking_id}/pay', [PaymentController::class, 'simulatePay'])->name('payments.simulate.pay');
    Route::post('/payments/simulate/{booking_id}/fail', [PaymentController::class, 'simulateFail'])->name('payments.simulate.fail');

    // Receipt
    Route::get('/payments/{booking_id}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    // Admin Dashboard (admin only)
    Route::middleware('can:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    });
});

require __DIR__.'/auth.php';
