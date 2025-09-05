<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\PaymentsController;

Route::prefix('payments')->middleware(['auth:member'])->group(function () {
    Route::get('/index', [PaymentsController::class, 'index'])->name('index');
    Route::get('/{method}/success', [PaymentsController::class, 'success'])->name('payment.success');
    Route::get('/{method}/cancel', [PaymentsController::class, 'cancel'])->name('payment.cancel');
});
