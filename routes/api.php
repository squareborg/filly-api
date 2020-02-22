<?php

use Illuminate\Http\Request;

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

Route::post('/s', 'API\SaleController');

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1.0'], function () {
    Route::get('me', 'API\UserController@index')->name('me');

    Route::get('/mySubscriptions', 'API\MySubscriptionsController')->name('api.mysubscriptions');
    Route::get('/myPrograms', 'API\MyProgramsController')->name('api.myprograms');

    Route::group(['prefix' => 'users', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'API\UsersController@index');
        Route::post('/', 'API\UsersController@create');
        Route::get('/{id}', 'API\UsersController@show');
        Route::put('/{id}', 'API\UsersController@update');
        Route::delete('/{id}', 'API\UsersController@destroy');
    });

    Route::group(['prefix' => 'settings', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'API\AdminSettingsController@index');
        Route::get('/{key}', 'API\AdminSettingsController@show')->name('api.setting.show');
        Route::put('/{key}', 'API\AdminSettingsController@update')->name('api.setting.update');
    });
    Route::get('/programCategories', 'API\ProgramCategoriesController')->name('api.programCategories.list');
    Route::group(['prefix' => 'programs'], function () {
        Route::get('/', 'API\ProgramsController@index')->name('api.programs.list');
        Route::get('/unapproved', 'API\ProgramsUnapprovedController')->name('api.programs.unapproved');
        Route::post('/approveAll', 'API\ProgramsApproveAllController')->name('api.programs.approveAll');
        Route::put('/{program}', 'API\ProgramsController@update')->name('api.programs.update');
        Route::post('/', 'API\ProgramsController@store')->name('api.programs.store');
        Route::get('/{program}', 'API\ProgramsController@show')->name('api.programs.show');
        Route::delete('/{program}', 'API\ProgramsController@destroy')->name('api.program.destroy');

        Route::post('/{program}/subscribe', 'API\ProgramSubscribeController')->name('subscribe');
        Route::post('/{program}/mediaUpload', 'API\ProgramMediaUploadController')->name('api.programs.media.upload');
        Route::delete('/{id}', 'API\ProgramsController@destroy');

        Route::get('/{program}/media', 'API\ProgramMediaController@index')->name('api.programs.media.list');

        Route::delete('/{program}/media/{programMedia}', 'API\ProgramMediaController@destroy')
            ->name('api.programs.media.delete');
    });
    Route::group(['prefix' => 'merchants'], function () {
        Route::get('/', 'API\MerchantsController@index')->name('api.merchants.list');
        Route::get('/{merchant}', 'API\MerchantsController@show')->name('api.merchants.show');
        Route::put('/{merchant}', 'API\MerchantsController@update')->name('api.merchants.update');
        Route::post('/{merchant}/subscribe', 'API\MerchantSubscribeController')->name('api.merchant.subscribe');
        Route::post('/{merchant}/logo', 'API\MerchantLogoController@store')->name('api.merchants.logo.store');
        Route::delete('/{merchant}/logo', 'API\MerchantLogoController@destroy')->name('api.merchants.logo.destroy');
        Route::delete('/{merchant}/affiliates/approvalqueue', 'API\MerchantLogoController@destroy')->name('api.merchants.affiliates.approvalqueue');
    });

    Route::group(['prefix' => 'merchant'], function () {
        Route::get('/affiliates/approvalqueue', 'API\MerchantSubscriptionApprovalController@index')->name('api.merchants.affiliates.approvalqueue');
    });


    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('/', 'API\ProgramSubscriptionController@index')->name('api.subscriptions.list');
        Route::get('/{subscription}', 'API\ProgramSubscriptionController@show')->name('api.subscriptions.show');
        Route::delete('/{subscription}', 'API\ProgramSubscriptionController@destroy')->name('api.subscriptions.destroy');
    });

    Route::group(['prefix' => 'merchantSubscriptions'], function () {
        Route::get('/', 'API\MerchantSubscriptionController@index')->name('api.merchant.subscriptions.list');
        Route::get('/{subscription}', 'API\MerchantSubscriptionController@show')->name('api.merchant.subscriptions.show');
        Route::put('/{subscription}', 'API\MerchantSubscriptionController@update')->name('api.merchant.subscriptions.update');
        Route::delete('/{subscription}', 'API\MerchantSubscriptionController@destroy')->name('api.merchant.subscriptions.destroy');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'API\RolesController@index');
    });
});

