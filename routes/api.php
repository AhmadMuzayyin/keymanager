<?php

use App\Http\Controllers\LisenseController;
use Illuminate\Support\Facades\Route;

Route::controller(LisenseController::class)->group(function () {
    Route::post('/license/check', 'check')->name('license.check');
});
