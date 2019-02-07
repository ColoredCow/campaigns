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
        return redirect()->route('campaigns');
    });

    Route::post('/campaign-image-upload', 'CampaignController@inlineImageUpload');

    Route::resource('campaigns', 'CampaignController')
        ->only(['index', 'create', 'store'])
        ->names([
            'index' => 'campaigns',
            'create' => 'campaigns.create',
            'store' => 'campaigns.store',
        ]);

    Route::resource('lists', 'SubscriptionListController')
        ->except(['show', 'delete'])
        ->names([
            'index' => 'lists',
            'create' => 'lists.create',
            'store' => 'lists.store',
            'edit' => 'lists.edit',
            'update' => 'lists.update',
        ]);

    Route::get('subscribers/upload', 'SubscriberController@uploadView')->name('subscribers.upload-view');
    Route::post('subscribers/upload', 'SubscriberController@upload')->name('subscribers.upload');

    Route::resource('subscribers', 'SubscriberController')
        ->except(['show'])
        ->names([
            'index' => 'subscribers',
            'create' => 'subscribers.create',
            'store' => 'subscribers.store',
            'edit' => 'subscribers.edit',
            'update' => 'subscribers.update',
            'destroy' => 'subscribers.destroy'
        ]);
});
