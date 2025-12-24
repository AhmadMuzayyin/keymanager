<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LisenseController;
use App\Http\Controllers\LisenseLogController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LicenseOrderController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('front.home');
    Route::get('/store', 'products')->name('front.products');
    Route::get('/store/{slug}', 'productDetail')->name('front.product.detail');
});

Route::controller(LicenseOrderController::class)->group(function () {
    Route::get('/order/license', 'licenseOnly')->name('front.order.license-only');
    Route::post('/order/license', 'storeLicenseOrder')->name('front.order.license.store');
    Route::get('/order/{slug}/{priceId?}', 'bundleOrder')->name('front.order.bundle');
    Route::post('/order/bundle', 'storeBundleOrder')->name('front.order.bundle.store');
    Route::get('/order-success/{orderNumber}', 'orderSuccess')->name('front.order.success');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.process');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(TrackingController::class)->group(function () {
    Route::get('/track', 'index')->name('tracking.index');
    Route::post('/track', 'search')->name('tracking.search');
    Route::get('/track/{purchaseCode}', 'show')->name('tracking.show');
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
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'index')->name('customers.index');
        Route::post('/customers', 'store')->name('customers.store');
        Route::get('/customers/{customer}', 'show')->name('customers.show');
        Route::patch('/customers/{customer}', 'update')->name('customers.update');
        Route::delete('/customers/{customer}', 'destroy')->name('customers.destroy');
    });
    Route::controller(LisenseLogController::class)->group(function () {
        Route::get('/license-logs', 'index')->name('logs.index');
        Route::get('/license-logs/ip/{ip}', 'show')->name('logs.show');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products', 'store')->name('products.store');
        Route::get('/products/{product}', 'show')->name('products.show');
        Route::get('/products/{product}/edit', 'edit')->name('products.edit');
        Route::patch('/products/{product}', 'update')->name('products.update');
        Route::delete('/products/{product}', 'destroy')->name('products.destroy');
        Route::post('/products/{product}/prices', 'storePrice')->name('products.prices.store');
        Route::patch('/prices/{price}', 'updatePrice')->name('products.prices.update');
        Route::delete('/prices/{price}', 'destroyPrice')->name('products.prices.destroy');
        Route::post('/products/{product}/versions', 'storeVersion')->name('products.versions.store');
        Route::delete('/versions/{version}', 'destroyVersion')->name('products.versions.destroy');
    });

    Route::controller(ProductCategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories.index');
        Route::post('/categories', 'store')->name('categories.store');
        Route::patch('/categories/{category}', 'update')->name('categories.update');
        Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/orders/create', 'create')->name('orders.create');
        Route::post('/orders', 'store')->name('orders.store');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::patch('/orders/{order}/status', 'updateStatus')->name('orders.update-status');
        Route::delete('/orders/{order}', 'destroy')->name('orders.destroy');
    });

    Route::controller(CustomOrderController::class)->group(function () {
        Route::get('/custom-orders', 'index')->name('custom-orders.index');
        Route::post('/custom-orders', 'store')->name('custom-orders.store');
        Route::get('/custom-orders/{customOrder}', 'show')->name('custom-orders.show');
        Route::patch('/custom-orders/{customOrder}', 'update')->name('custom-orders.update');
        Route::delete('/custom-orders/{customOrder}', 'destroy')->name('custom-orders.destroy');
        Route::post('/custom-orders/{customOrder}/messages', 'sendMessage')->name('custom-orders.messages.store');
        Route::post('/custom-orders/{customOrder}/milestones', 'storeMilestone')->name('custom-orders.milestones.store');
        Route::patch('/milestones/{milestone}', 'updateMilestone')->name('custom-orders.milestones.update');
        Route::delete('/milestones/{milestone}', 'destroyMilestone')->name('custom-orders.milestones.destroy');
    });
});
