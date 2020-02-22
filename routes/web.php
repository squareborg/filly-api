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
    return view('welcome');
});


Route::get('/user/confirm/{token}/email', 'User\EmailConfirmationController@index')->name('user.confirm.email');
Route::get('/user/confirm/{token}/delete', 'User\DeleteConfirmationController@destroy')->name('user.confirm.delete');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/in/{subscription}', 'InboundController')->name('inbound');
Route::group(['middleware' => ['auth']], function(){
    Route::get('/', 'HomeController@index')->name('dashboard');

    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'AdminController')->name('admin.home');
        Route::get('/categories', 'Admin\AdminCategoriesController@index')->name('admin.categories.index');
        Route::get('/categories/{programCategory}', 'Admin\AdminCategoriesController@edit')->name('admin.categories.edit');
        Route::post('/categories/{programCategory}', 'Admin\AdminCategoriesController@update')->name('admin.categories.update');
        Route::get('/categories/{programCategory}/delete', 'Admin\AdminCategoriesController@destroy')->name('admin.categories.destroy');
        Route::post('/categories/', 'Admin\AdminCategoriesController@store')->name('admin.categories.store');
        Route::get('/users', 'AdminUsersController@index')->name('admin.users.index');
        Route::get('/users/create', 'AdminUsersController@create')->name('admin.users.create');
        Route::get('/users/{id}', 'AdminUsersController@show')->name('admin.users.detail');
        Route::get('/programs', 'Admin\AdminProgramsController@index')->name('admin.programs.index');
        Route::get('/sales', 'AdminSalesController@index')->name('admin.sales.index');

    });
    Route::group(['prefix' => 'affiliate'], function () {
        Route::get('/', 'AffiliateController@index')->name('affiliate.home');
        Route::get('/program/{subscription}', 'AffiliateProgramController')->name('affiliate.program.show');
    });
    Route::group(['prefix' => 'merchant'], function () {
        Route::get('/', 'MerchantController@index')->name('merchant.home');
        Route::get('/link/woocommerce', 'LinkWooCommerceController@index')->name('merchant.link.woocommerce.index');
        Route::get('/programs/create', 'ProgramController@create')->name('merchant.programs.create');
        Route::post('/programs/store', 'ProgramController@store')->name('merchant.programs.edit');
        Route::get('/programs/{program}/edit', 'ProgramController@edit')->name('merchant.programs.edit');
    });
});
