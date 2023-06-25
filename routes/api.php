<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\SenderIdentityController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('subscriber', SubscriberController::class)->except(['create', 'edit']);
    Route::resource('tag', TagController::class)->except(['create', 'edit']);
    Route::resource('sender-identity', SenderIdentityController::class)->except(['create', 'edit']);
    Route::resource('campaign', CampaignController::class)->except(['create', 'edit']);
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);
});
Route::resource('userRoles', PermissionController::class)
->except(['create', 'edit', 'destroy'])
->names([
    'index' => 'userRoles.index',
    'store' => 'userRoles.store',
    'show' => 'userRoles.show',
    'update' => 'userRoles.update',
]);


require __DIR__.'/api/auth.php';
