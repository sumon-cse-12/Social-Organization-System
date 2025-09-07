<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\PaymentsController;

Route::prefix('payments')->middleware(['auth:member'])->group(function () {
    Route::get('/index', [PaymentsController::class, 'index'])->name('index');
    Route::post('/pay/now/{method}', [PaymentsController::class, 'pay'])->name('pay.now');
    Route::get('/{method}/cancel', [PaymentsController::class, 'cancel'])->name('payment.cancel');
});
