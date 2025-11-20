<?php

use Illuminate\Support\Facades\Route;

Route::prefix('customer-statuses')->group(function () {
    require __DIR__.'/api/customer_status.php';
});

Route::prefix('stock-softwares')->group(function () {
    require __DIR__.'/api/stock_software.php';
});

Route::prefix('franchises')->group(function () {
    require __DIR__.'/api/franchises.php';
});

Route::prefix('customer-langs')->group(function () {
    require __DIR__.'/api/customer-langs.php';
});

Route::prefix('customer-locations')->group(function () {
    require __DIR__.'/api/customer-locations.php';
});

Route::prefix('customer-typologies')->group(function () {
    require __DIR__.'/api/customer-typologies.php';
});

Route::prefix('customer-refusal-reasons')->group(function () {
    require __DIR__.'/api/customer-refusal-reasons.php';
});

Route::prefix('customer-countries')->group(function () {
    require __DIR__.'/api/customer-countries.php';
});