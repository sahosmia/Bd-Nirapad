<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\MobileBankingController;
use App\Http\Controllers\MobileRechargeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [AuthController::class , 'index'])->name('index');
Route::post("/login/submit", [AuthController::class , 'login_submit'])->name('login_submit');

Route::group(['middleware' => 'instaload'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get("/home", [DashboardController::class , 'dashboard'])->name('dashboard');
        Route::get("/users/{refkey}", [UserController::class , 'users'])->name('users');
        Route::get("/check", [UserController::class , 'check_username'])->name('check_username');
        Route::post("/user/submit", [UserController::class , 'user_submit'])->name('user_submit');
        Route::post("/add-credit", [CreditController::class , 'add_credit'])->name('add_credit');
        Route::post("/refund-credit", [CreditController::class , 'refund_credit'])->name('refund_credit');
        
        Route::get("/credit-request", [CreditController::class , 'credit_request'])->name('credit_request');
        
        Route::get("/reports/{refkey}", [ReportController::class , 'reports'])->name('reports');
        Route::get("/all-reports/{refkey}", [ReportController::class , 'all_reports'])->name('all_reports');
        Route::get("/plans", [ReportController::class , 'plans'])->name('plans');
        Route::get("/bank", [BankController::class , 'bank'])->name('bank');
        Route::get("/bank-districts/{id}", [BankController::class , 'bank_districts'])->name('bank_districts');
        Route::get("/bank-branches/{id}", [BankController::class , 'bank_branches'])->name('bank_branches');
        Route::post("/bank-request-submit", [BankController::class , 'bank_request_submit'])->name('bank_request_submit');
        Route::post("/bank-request-update", [BankController::class , 'ban_request_update'])->name('ban_request_update');
        Route::get("/requests/{refkey}", [BankController::class , 'requests'])->name('requests');
        Route::get("/mobile-banking", [MobileBankingController::class , 'mobile_banking'])->name('mobile_banking');
        Route::post("/mobile-banking-submit", [MobileBankingController::class , 'mobile_banking_submit'])->name('mobile_banking_submit');
        Route::post("/add-partner-submit", [UserController::class , 'add_partner_submit'])->name('add_partner_submit');
        Route::get("/mobile-banking-request/{refkey}", [MobileBankingController::class , 'mobile_banking_request'])->name('mobile_banking_request');
        Route::post("/mobile-banking-request-update", [MobileBankingController::class , 'mobile_banking_request_update'])->name('mobile_banking_request_update');
        Route::get("/mobile-recharge", [MobileRechargeController::class , 'mobile_recharge'])->name('mobile_recharge');
        Route::post("/mobile-recharge-submit", [MobileRechargeController::class , 'mobile_recharge_submit'])->name('mobile_recharge_submit');
        Route::get("/mobile-recharge-request/{refkey}", [MobileRechargeController::class , 'mobile_recharge_request'])->name('mobile_recharge_request');
        Route::post("/mobile-recharge-request-update", [MobileRechargeController::class , 'mobile_recharge_request_update'])->name('mobile_recharge_request_update');
        Route::get("/profile", [ProfileController::class , 'profile'])->name('profile');
        Route::post("/profile-update-submit", [ProfileController::class , 'profile_update_submit'])->name('profile_update_submit');
        Route::get("/find-operator/{id}", [MobileRechargeController::class , 'find_operator'])->name('find_operator');
        Route::post("/create-pin", [ProfileController::class , 'create_pin'])->name('create_pin');
        Route::post("/reset-pin-submit", [UserController::class , 'reset_pin_submit'])->name('reset_pin_submit');
        Route::post("/reset-password-submit", [UserController::class , 'reset_password_submit'])->name('reset_password_submit');
        Route::get("/deactive-account/{userid}", [UserController::class , 'deactive_account'])->name('deactive_account');
        Route::get("/active-account/{userid}", [UserController::class , 'active_account'])->name('active_account');
        Route::get("/change-password", [ProfileController::class , 'change_password'])->name('change_password');
        Route::post("/change-password/submit", [ProfileController::class , 'change_password_submit'])->name('change_password_submit');
        Route::get("/change-pin", [ProfileController::class , 'change_pin'])->name('change_pin');
        Route::post("/change-pin/submit", [ProfileController::class , 'change_pin_submit'])->name('change_pin_submit');
        Route::get("/logout", [AuthController::class , 'logout'])->name('logout');
        Route::delete("/delete-notification/{id}", [NotificationController::class, 'delete_notification'])->name('delete_notification');


    });
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
