<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'bookkeeping.'], function () {
    Route::resource('/ledger', 'LedgerController');
    Route::resource('/ledgerRecord', 'LedgerRecordController');
});
