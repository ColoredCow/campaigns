<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Aws\Api\ApiProvider;
use App\Http\Controllers\SubscriberController;

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

Route::prefix('v1')->middleware('client')->group(function () {
	Route::post('/subscriber', 'SubscriberController@store');
	Route::post('recieveSubscriber', [SubscriberController::class, 'subscriber']);
});

