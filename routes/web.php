<?php

use App\Http\Controllers\BackEndController;
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

Route::get("/", [BackEndController::class , 'index'])->name('index');
Route::post("/login/submit", [BackEndController::class , 'login_submit'])->name('login_submit');

Route::group(['middleware' => 'instaload'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get("/home", [BackEndController::class , 'dashboard'])->name('dashboard');
        Route::get("/users/{refkey}", [BackEndController::class , 'users'])->name('users');
        Route::get("/check", [BackEndController::class , 'check_username'])->name('check_username');
        Route::post("/user/submit", [BackEndController::class , 'user_submit'])->name('user_submit');
        Route::post("/add-credit", [BackEndController::class , 'add_credit'])->name('add_credit');
        Route::post("/refund-credit", [BackEndController::class , 'refund_credit'])->name('refund_credit');
        
        Route::get("/credit-request", [BackEndController::class , 'credit_request'])->name('credit_request');
        // Route::post("/request-credit", [BackEndController::class , 'request_credit'])->name('request_credit');
        // Route::post("/credit-request-update", [BackEndController::class , 'credit_request_update'])->name('credit_request_update');
        
        Route::get("/reports/{refkey}", [BackEndController::class , 'reports'])->name('reports');
        Route::get("/all-reports/{refkey}", [BackEndController::class , 'all_reports'])->name('all_reports');
        Route::get("/plans", [BackEndController::class , 'plans'])->name('plans');
        Route::get("/bank", [BackEndController::class , 'bank'])->name('bank');
        Route::get("/bank-districts/{id}", [BackEndController::class , 'bank_districts'])->name('bank_districts');
        Route::get("/bank-branches/{id}", [BackEndController::class , 'bank_branches'])->name('bank_branches');
        Route::post("/bank-request-submit", [BackEndController::class , 'bank_request_submit'])->name('bank_request_submit');
        Route::post("/bank-request-update", [BackEndController::class , 'ban_request_update'])->name('ban_request_update');
        Route::get("/requests/{refkey}", [BackEndController::class , 'requests'])->name('requests');
        Route::get("/mobile-banking", [BackEndController::class , 'mobile_banking'])->name('mobile_banking');
        Route::post("/mobile-banking-submit", [BackEndController::class , 'mobile_banking_submit'])->name('mobile_banking_submit');
        Route::post("/add-partner-submit", [BackEndController::class , 'add_partner_submit'])->name('add_partner_submit');
        Route::get("/mobile-banking-request/{refkey}", [BackEndController::class , 'mobile_banking_request'])->name('mobile_banking_request');
        Route::post("/mobile-banking-request-update", [BackEndController::class , 'mobile_banking_request_update'])->name('mobile_banking_request_update');
        Route::get("/mobile-recharge", [BackEndController::class , 'mobile_recharge'])->name('mobile_recharge');
        Route::post("/mobile-recharge-submit", [BackEndController::class , 'mobile_recharge_submit'])->name('mobile_recharge_submit');
        Route::get("/mobile-recharge-request/{refkey}", [BackEndController::class , 'mobile_recharge_request'])->name('mobile_recharge_request');
        Route::post("/mobile-recharge-request-update", [BackEndController::class , 'mobile_recharge_request_update'])->name('mobile_recharge_request_update');
        Route::get("/profile", [BackEndController::class , 'profile'])->name('profile');
        Route::post("/profile-update-submit", [BackEndController::class , 'profile_update_submit'])->name('profile_update_submit');
        Route::get("/find-operator/{id}", [BackEndController::class , 'find_operator'])->name('find_operator');
        Route::post("/create-pin", [BackEndController::class , 'create_pin'])->name('create_pin');
        Route::post("/reset-pin-submit", [BackEndController::class , 'reset_pin_submit'])->name('reset_pin_submit');
        Route::post("/reset-password-submit", [BackEndController::class , 'reset_password_submit'])->name('reset_password_submit');
        Route::get("/deactive-account/{userid}", [BackEndController::class , 'deactive_account'])->name('deactive_account');
        Route::get("/active-account/{userid}", [BackEndController::class , 'active_account'])->name('active_account');
        Route::get("/change-password", [BackEndController::class , 'change_password'])->name('change_password');
        Route::post("/change-password/submit", [BackEndController::class , 'change_password_submit'])->name('change_password_submit');
        Route::get("/change-pin", [BackEndController::class , 'change_pin'])->name('change_pin');
        Route::post("/change-pin/submit", [BackEndController::class , 'change_pin_submit'])->name('change_pin_submit');
        Route::get("/logout", [BackEndController::class , 'logout'])->name('logout');
        Route::delete("/delete-notification/{id}", [BackEndController::class, 'delete_notification'])->name('delete_notification');


    });
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
