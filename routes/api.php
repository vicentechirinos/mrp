<?php

use App\Http\Controllers\PublicationController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    // routes
});

Route::apiResource('user', UserController::class);
Route::post('publication/seen/{publication}', [PublicationController::class, 'seen'])->name('publication-seen');
Route::apiResource('publication', PublicationController::class);
