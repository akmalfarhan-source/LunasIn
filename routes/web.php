<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - LunasIn
|--------------------------------------------------------------------------
| Semua route inti dilindungi middleware 'auth' agar hanya user yang
| sudah login yang bisa mengaksesnya.
*/

// Redirect halaman utama ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ============================================================
// ROUTE YANG MEMERLUKAN LOGIN (middleware auth)
// ============================================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Kontak
    Route::resource('contacts', ContactController::class);

    // CRUD Transaksi
    Route::resource('loans', LoanController::class);
    Route::post('loans/{loan}/mark-paid', [LoanController::class, 'markPaid'])
        ->name('loans.mark-paid');

    // Pembayaran (bersarang di dalam loans)
    // POST   /loans/{loan}/payments         → PaymentController@store
    // DELETE /loans/{loan}/payments/{payment} → PaymentController@destroy
    Route::post('loans/{loan}/payments', [PaymentController::class, 'store'])
        ->name('loans.payments.store');
    Route::delete('loans/{loan}/payments/{payment}', [PaymentController::class, 'destroy'])
        ->name('loans.payments.destroy');
});

// Route autentikasi (login, register, logout) dari Breeze
require __DIR__.'/auth.php';
