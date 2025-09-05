<?php

use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\FeeController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\MemberLoginController;
use App\Http\Controllers\Auth\MemberRegisterController;
use App\Http\Controllers\Admin\PaymentSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Member\MemberDashboardController;

Route::get('/paypal-test', function() {
    $paypal = new PayPal();
    dd($paypal);
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
});

// Logout route should remain accessible
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Protected admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('admin.dashboard.create');
    Route::get('/payment/settings', [PaymentSettingsController::class, 'index'])->name('admin.payment.settings.index');
    Route::post('/payment/settings/store', [PaymentSettingsController::class, 'store'])->name('admin.payment.settings.store');
});

Route::prefix('member')->group(function () {
    // Registration
    Route::get('register', [MemberRegisterController::class, 'showRegistrationForm'])->name('member.register');
    Route::post('register', [MemberRegisterController::class, 'register']);

    // Login
    Route::get('login', [MemberLoginController::class, 'showLoginForm'])->name('member.login');
    Route::post('login', [MemberLoginController::class, 'login']);
    Route::post('logout', [MemberLoginController::class, 'logout'])->name('member.logout');

    // Protected routes
    Route::middleware(['auth:member'])->group(function () {
        Route::get('dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
        Route::get('profile', [ProfileController::class, 'index'])->name('member.profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('member.profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('member.profile.update');
        Route::get('fees', [FeeController::class, 'index'])->name('member.fees');
        Route::post('fees/{fee}/pay', [FeeController::class, 'payFee'])->name('member.fees.pay');
    });
});

