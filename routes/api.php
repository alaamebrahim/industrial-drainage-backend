<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Claims\ClaimDetailsController;
use App\Http\Controllers\Claims\ClaimsController;
use App\Http\Controllers\Clients\ClientDetailsController;
use App\Http\Controllers\Clients\ClientsController;
use App\Http\Controllers\DashboardStatsController;
use App\Http\Controllers\LoggedInUserInfoController;
use App\Http\Controllers\Manage\Users\UserPermissionsController;
use App\Http\Controllers\Manage\Users\UsersController;
use App\Http\Controllers\Payments\PaymentsController;
use App\Http\Controllers\Results\ClientResultsDataController;
use App\Http\Controllers\Results\ResultDetailsController;
use App\Http\Controllers\Results\ResultsController;
use App\Http\Controllers\Samples\SampleDetailsController;
use App\Http\Controllers\Samples\SamplesController;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', LoginController::class);
Route::post('auth/logout', LogoutController::class);
Route::post('app-info', AppInfoController::class);

Route::middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::post('dashboard-stats', DashboardStatsController::class);

    // Manage
    Route::group(['prefix' => 'manage'], function () {
        Route::resource('users', UsersController::class);
    });

    Route::get('user-info', LoggedInUserInfoController::class);

    // Clients
    Route::resource('clients', ClientsController::class);
    Route::post('client-details/{id}', ClientDetailsController::class);

    // Samples
    Route::resource('samples', SamplesController::class);
    Route::resource('sample-details', SampleDetailsController::class);

    // results
    Route::resource('results', ResultsController::class);
    Route::post('result-details/{id}', ResultDetailsController::class);
    Route::post('client-results/{id}', ClientResultsDataController::class);

    // Claims
    Route::resource('claims', ClaimsController::class)->only(['index', 'show', 'store', 'destroy']);
    Route::post('claim-details/{id}', ClaimDetailsController::class);

    // Payments
    Route::resource('payments', PaymentsController::class)->only(['index', 'show', 'store', 'destroy']);

    // API
//    Route::group(['prefix' => 'list'], function () {
//    });

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
