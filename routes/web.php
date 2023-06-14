<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::get('unsubscribe/{subscriber}', 'SubscriberController@unsubscribe')->name('unsubscribe');

Route::middleware('auth')->group(function () {
    Route::get('home', function () {
        return redirect()->route('campaign.index');
    });
    Route::post('/campaign-image-upload', 'CampaignController@inlineImageUpload');
    Route::resource('campaign', 'CampaignController')->only(['index', 'create', 'store', 'show']);
    Route::resource('list', 'SubscriptionListController')->except(['show']);
    Route::resource('sender-identity', 'SenderIdentityController')->except(['show', 'delete']);
    Route::get('subscriber/upload', 'SubscriberController@uploadView')->name('subscriber.upload-view');
    Route::post('subscriber/upload', 'SubscriberController@upload')->name('subscriber.upload');
    Route::resource('subscriber', 'SubscriberController')->except(['show']);

    Route::resource('user','UserController')->only(['index', 'edit', 'update']);
    Route::get('user/registers', 'UserController@create')->name('user.create');
    Route::post('registeruser', 'UserController@store')->name('registeruser');
    Route::post('user', 'UserController@destroy')->name('user.delete');
});
