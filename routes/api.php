<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('check-licence/{key}',[App\Http\Controllers\LicencesController::class,'check_licence'])->name('check_licence');
Route::get('add-devices/{key}/{type}/{count}', [App\Http\Controllers\LicencesController::class,'add_devices'])->name('add_devices');
