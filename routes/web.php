<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LisenseController;
use App\Http\Controllers\LisenseLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', function () {
        return redirect('/');
    })->name('login.form');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
    });
    Route::controller(LisenseController::class)->group(function () {
        Route::get('/licenses', 'index')->name('licenses.index');
        Route::post('/licenses', 'store')->name('licenses.store');
        Route::patch('/licenses/{license}', 'update')->name('licenses.update');
        Route::delete('/licenses/{license}', 'destroy')->name('licenses.destroy');
    });
    Route::controller(LisenseLogController::class)->group(function () {
        Route::get('/license-logs', 'index')->name('logs.index');
        Route::get('/license-logs/ip/{ip}', 'show')->name('logs.show');
    });
});
