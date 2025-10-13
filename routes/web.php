<?php

use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HomeController::class, 'login'])->name('login.submit');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/otp', [HomeController::class, 'showOtpForm'])->name('otp');
Route::post('/otp', [HomeController::class, 'verifyOtp'])->name('otp.verify');
// Step 1: Request password reset
Route::get('/password/email', [ResetPasswordController::class, 'showEmailForm'])->name('password.email.form');
Route::post('/password/email', [ResetPasswordController::class, 'sendOtp'])->name('password.email.send');
// Step 2: OTP verification
Route::get('/password/verify-otp', [ResetPasswordController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/password/verify-otp', [ResetPasswordController::class, 'verifyOtp'])->name('password.otp.verify');

// Step 3: Change password
Route::get('/password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');

// Protect admin dashboard with auth middleware
Route::middleware(['auth'])->group(function () {
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});
