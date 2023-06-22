<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\SenderIdentityController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::resource('subscriber', SubscriberController::class)->except(['create', 'edit']);
    Route::resource('list', ListController::class)->except(['create', 'edit']);
    Route::resource('sender-identity', SenderIdentityController::class)->except(['create', 'edit']);
});

require __DIR__ . '/api/auth.php';
