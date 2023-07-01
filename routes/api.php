<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SenderIdentityController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
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
    Route::resource('role', RoleController::class)->except(['create', 'edit']);
    Route::resource('user/user', UserController::class)->except(['create', 'edit']);
    Route::post('user/update-user-role', [UserController::class, 'updateUserRoles'])->name('user.updateUserRoles');
    Route::post('role/update-role-permission', [RoleController::class, 'updateRolePermissions'])->name('role.updateRolePermissions');
});

require __DIR__.'/api/auth.php';
