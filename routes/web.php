<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
    Route::get('/', 'LoginController@login')->name('index');
    Route::get('{provider}', 'LoginController@loginSocial')->name('social');
    Route::get('callback/{provider}', 'LoginController@callback')->name('callback');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::group(['namespace' => 'Bookkeeping', 'prefix' => 'bookkeeping', 'as' => 'bookkeeping.'], function () {
        Route::resource('/ledger', 'LedgerController');
        Route::resource('/ledgerRecord', 'LedgerRecordController');
    });

    Route::group(['namespace' => 'Investment', 'prefix' => 'investment', 'as' => 'investment.'], function () {
        Route::resource('/commitment', 'CommitmentController', ['only' => ['index', 'show']]);
        Route::resource('/statement', 'StatementController', ['only' => ['index', 'store']]);
    });
});
