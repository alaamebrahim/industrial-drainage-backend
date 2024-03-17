<?php

use App\Http\Controllers\Claims\PrintClaimController;
use App\Http\Controllers\Clients\PrintClientsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return \App\DataProcessors\Claims\ClaimDataProcess::calculate(\App\Models\Claim::query()->find(52));
});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('print')
    ->group(function () {
        Route::get('/print-claim/{claimId}', PrintClaimController::class);
        Route::get('/print-clients', PrintClientsController::class);

    });
