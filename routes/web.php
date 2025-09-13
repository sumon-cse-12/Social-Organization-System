<?php

use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\FeeController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MeetingController;
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
    Route::get('/member/index', [MemberController::class, 'index'])->name('admin.member.index');

    //Mettings
    Route::get('/meetings/index', [MeetingController::class, 'index'])->name('admin.meeting.index');
    Route::get('/meeting/create', [MeetingController::class, 'create'])->name('admin.meeting.create');
    Route::post('/meeting/store', [MeetingController::class, 'store'])->name('admin.meeting.store');


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
        Route::get('profile/details/{id}', [ProfileController::class, 'details'])->name('member.details');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('member.profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('member.profile.update');
        Route::get('fees', [FeeController::class, 'index'])->name('member.fees');
        Route::post('fees/{fee}/pay', [FeeController::class, 'payFee'])->name('member.fees.pay');

        Route::get('all', [ProfileController::class, 'all_member'])->name('get.all');
        Route::get('notifications', [ProfileController::class, 'notifications'])->name('notifications');

        Route::get('handleReturn', [FeeController::class, 'handleReturn'])->name('handleReturn');
        Route::get('handleCancel', [FeeController::class, 'handleCancel'])->name('handleCancel');
    });
});

