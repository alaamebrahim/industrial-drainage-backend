<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Clients\ClientsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\LoggedInUserInfoController;
use App\Http\Controllers\Users\UserPermissionsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', LoginController::class);
Route::post('auth/logout', LogoutController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user-info', LoggedInUserInfoController::class);

    // Clients
    Route::resource('clients', ClientsController::class);

    // API
//    Route::group(['prefix' => 'list'], function () {
//    });

    // Dashboard
    Route::get('dashboard', DashboardController::class);

    // Users
    Route::resource('users', UsersController::class);
    Route::get('user-permissions', UserPermissionsController::class);


    // Reports
//    Route::group(['prefix' => 'reports'], function () {
//    });

    // Letters
//    Route::group(['prefix' => 'letters'], function () {
//        Route::post('debts', DebtsLetterController::class);
//    });
});
