<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Claims\ClaimsController;
use App\Http\Controllers\Clients\ClientsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\LoggedInUserInfoController;
use App\Http\Controllers\Results\ResultsController;
use App\Http\Controllers\Samples\SampleDetailsController;
use App\Http\Controllers\Samples\SamplesController;
use App\Http\Controllers\Users\UserPermissionsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', LoginController::class);
Route::post('auth/logout', LogoutController::class);
Route::resource('claim-test', ClaimsController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user-info', LoggedInUserInfoController::class);

    // Clients
    Route::resource('clients', ClientsController::class);

    // Samples
    Route::resource('samples', SamplesController::class);
    Route::resource('sample-details', SampleDetailsController::class);

    // Sample results
    Route::resource('results', ResultsController::class);

    // Claims
    Route::resource('claims', ClaimsController::class);

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
