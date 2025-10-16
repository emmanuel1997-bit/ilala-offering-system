<?php

use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SettingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Member\MemberControler;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\StewardShipController;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth'])->group(function () {
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/roles/store', [UserController::class, 'createRole'])->name('roles.createRole');
Route::post('/roles/delete', [UserController::class, 'deleteRole'])->name('roles.destroy');
Route::post('/roles/assign{user}', [UserController::class, 'assignToUser'])->name('roles.assignToUser');
Route::post('/roles/{role}/update', [UserController::class, 'updateRole'])->name('roles.update');
Route::get('/user/settings', [UserController::class, 'settings'])->name('users.settings');
Route::resource('users', UserController::class);

Route::resource('members', MemberController::class);
Route::resource('stewardship', StewardShipController::class);
Route::resource('tithes', TitheController::class);
Route::resource('thanksgiving', ThanksgivingController::class);
Route::resource('income', IncomeController::class);
Route::resource('expenses', ExpenseController::class);
Route::resource('ministries', MinistryController::class);
Route::resource('receipts', ReceiptController::class);
Route::resource('messages', MessageController::class);
Route::resource('settings', SettingController::class);

Route::resource('users', UserController::class);

Route::get('/receipt', [PdfController::class, 'generateReceipt'])->name('settings.receipt.preview');

Route::get('locale/{lang}', function($lang){
    if (in_array($lang, ['en','sw'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('locale.switch');


});


