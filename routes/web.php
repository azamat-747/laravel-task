<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resources([
        'orders' => OrdersController::class,
        'invoices' => InvoicesController::class
    ]);

    Route::get('invoices/pdf/download/{id}', [InvoicesController::class, 'downloadPdf'])->name('invoices.downloadPdf');

    Route::get('orders/pdf/{id}', [OrdersController::class, 'getPdf'])->name('orders.pdf');
    Route::get('orders/pdf/download/{id}', [OrdersController::class, 'downloadPdf'])->name('orders.downloadPdf');
});

require __DIR__.'/auth.php';
