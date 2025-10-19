<?php

use App\Http\Controllers\Member\AnnouncementController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SettingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Member\IncomeController;
use App\Http\Controllers\Member\ExpenseController;
use App\Http\Controllers\Member\MemberControler;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\MinistryController;
use App\Http\Controllers\Member\ReceiptController;

use App\Http\Controllers\Member\StewardShipController;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\Member\SabbathSchoolController;
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

Route::resource('thanksgiving', ThanksgivingController::class);
Route::resource('ministries', MinistryController::class);
Route::resource('receipts', ReceiptController::class);
Route::resource('messages', MessageController::class);
Route::resource('settings', SettingController::class);



// receipt
Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
Route::post('/receipts/verify/{id}', [ReceiptController::class, 'verify'])->name('receipts.verify');
Route::post('/receipts/unverify/{id}', [ReceiptController::class, 'unverify'])->name('receipts.unverify');
Route::post('/receipts/send-message', [ReceiptController::class, 'sendMessage'])->name('receipts.sendMessage');
// Route::post('/receipts/print-selected', [ReceiptController::class, 'printSelected'])->name('receipts.printSelected');
Route::post('/receipt', [PdfController::class, 'generateReceipt'])->name('receipts.printSelected');
Route::get('/receipts/view/{id}', [ReceiptController::class, 'view'])->name('receipts.view');
// end receipt


// income

Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
Route::delete('/income/{income}', [IncomeController::class, 'destroy'])->name('income.destroy');
// endincome

// expenses

Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');

// end expenses
//ministry
Route::get('/ministries', [MinistryController::class, 'index'])->name('ministries.index');
// end ministry

// member
Route::post('/members/store', [MemberController::class, 'members.store']);
Route::put('/members/{id}', [MemberController::class, 'members.update']);
Route::delete('/members/{id}', [MemberController::class, 'members.destroy']);

// end member

//sabath school
Route::post('/sabbath-schools/store', [SabbathSchoolController::class, 'store'])->name('sabbath-schools.store');
Route::delete('/sabbath-schools/delete/{id}', [SabbathSchoolController::class, 'destroy'])->name('sabbath-schools.destroy');
Route::put('/sabbath-schools/edit/{id}', [SabbathSchoolController::class, 'update'])->name('sabbath-schools.edit');
Route::get('/sabbath-schools/view/{id}', [SabbathSchoolController::class, 'show'])->name('members.sabbath-schools.show');
Route::post('sabbath-schools/{id}/add-member', [SabbathSchoolController::class, 'addMember'])->name('sabbath-schools.addMember');
Route::delete('sabbath-schools/{school_id}/remove-member/{member_id}', [SabbathSchoolController::class, 'removeMember'])->name('sabbath-schools.removeMember');

//end sabath school

//anouncement
Route::get('announcements/', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::post('announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
Route::post('announcements/edit/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::resource('users', UserController::class);

Route::get('/receipt', [PdfController::class, 'generateReceipt'])->name('settings.receipt.preview');

Route::get('locale/{lang}', function($lang){
    if (in_array($lang, ['en','sw'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('locale.switch');


});


