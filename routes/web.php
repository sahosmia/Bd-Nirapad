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

Route::get("/", [AuthController::class , 'create'])->name('login.create');
Route::post("/login", [AuthController::class , 'store'])->name('login.store');

Route::group(['middleware' => 'instaload'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get("/home", [DashboardController::class , 'index'])->name('dashboard.index');
        Route::get("/users/{refkey}", [UserController::class , 'index'])->name('users.index');
        Route::get("/check", [UserController::class , 'check_username'])->name('users.check');
        Route::post("/users", [UserController::class , 'store'])->name('users.store');
        Route::post("/credits", [CreditController::class , 'store'])->name('credits.store');
        Route::post("/credits/refund", [CreditController::class , 'refund'])->name('credits.refund');
        
        Route::get("/credits", [CreditController::class , 'index'])->name('credits.index');
        
        Route::get("/reports/{refkey}", [ReportController::class , 'index'])->name('reports.index');
        Route::get("/reports/user/{refkey}", [ReportController::class , 'show'])->name('reports.show');
        Route::get("/plans", [ReportController::class , 'plans'])->name('plans.index');
        Route::get("/banks/create", [BankController::class , 'create'])->name('banks.create');
        Route::get("/banks/districts/{id}", [BankController::class , 'getDistricts'])->name('banks.districts');
        Route::get("/banks/branches/{id}", [BankController::class , 'getBranches'])->name('banks.branches');
        Route::post("/banks", [BankController::class , 'store'])->name('banks.store');
        Route::put("/banks/{id}", [BankController::class , 'update'])->name('banks.update');
        Route::get("/banks/{refkey}", [BankController::class , 'index'])->name('banks.index');
        Route::get("/mobile-banking/create", [MobileBankingController::class , 'create'])->name('mobile-banking.create');
        Route::post("/mobile-banking", [MobileBankingController::class , 'store'])->name('mobile-banking.store');
        Route::post("/users/add-partner", [UserController::class , 'add_partner_submit'])->name('users.add-partner');
        Route::get("/mobile-banking", [MobileBankingController::class , 'index'])->name('mobile-banking.index');
        Route::put("/mobile-banking/{id}", [MobileBankingController::class , 'update'])->name('mobile-banking.update');
        Route::get("/mobile-recharge/create", [MobileRechargeController::class , 'create'])->name('mobile-recharge.create');
        Route::post("/mobile-recharge", [MobileRechargeController::class , 'store'])->name('mobile-recharge.store');
        Route::get("/mobile-recharge", [MobileRechargeController::class , 'index'])->name('mobile-recharge.index');
        Route::put("/mobile-recharge/{id}", [MobileRechargeController::class , 'update'])->name('mobile-recharge.update');
        Route::get("/profile", [ProfileController::class , 'show'])->name('profile.show');
        Route::put("/profile", [ProfileController::class , 'update'])->name('profile.update');
        Route::get("/operators/{id}", [MobileRechargeController::class , 'find_operator'])->name('operators.find');
        Route::post("/profile/pin", [ProfileController::class , 'create_pin'])->name('profile.pin');
        Route::post("/users/reset-pin", [UserController::class , 'reset_pin_submit'])->name('users.reset-pin');
        Route::post("/users/reset-password", [UserController::class , 'reset_password_submit'])->name('users.reset-password');
        Route::put("/users/{id}/deactivate", [UserController::class , 'deactive_account'])->name('users.deactivate');
        Route::put("/users/{id}/activate", [UserController::class , 'active_account'])->name('users.activate');
        Route::get("/profile/change-password", [ProfileController::class , 'change_password'])->name('profile.change-password');
        Route::post("/profile/change-password", [ProfileController::class , 'change_password_submit'])->name('profile.change-password.submit');
        Route::get("/profile/change-pin", [ProfileController::class , 'change_pin'])->name('profile.change-pin');
        Route::post("/profile/change-pin", [ProfileController::class , 'change_pin_submit'])->name('profile.change-pin.submit');
        Route::get("/logout", [AuthController::class , 'destroy'])->name('logout');
        Route::delete("/notifications/{id}", [NotificationController::class, 'destroy'])->name('notifications.destroy');


    });
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
