<?php

use Illuminate\Support\Facades\Route;

Route::resource('/ledger', 'LedgerController');
Route::resource('/ledgerRecord', 'LedgerRecordController');
