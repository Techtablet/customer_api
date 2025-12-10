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

Route::prefix('customer-addresses')->group(function () {
    require __DIR__.'/api/customer-addresses.php';
});

Route::prefix('techtablet-sellers')->group(function () {
    require __DIR__.'/api/techtablet-sellers.php';
});

Route::prefix('customer-canvassing-steps')->group(function () {
    require __DIR__.'/api/customer-canvassing-steps.php';
});

Route::prefix('customer-contact-titles')->group(function () {
    require __DIR__.'/api/customer-contact-titles.php';
});

Route::prefix('profiles')->group(function () {
    require __DIR__.'/api/profiles.php';
});

Route::prefix('customer-contact-roles')->group(function () {
    require __DIR__.'/api/customer-contact-roles.php';
});

Route::prefix('store-groups')->group(function () {
    require __DIR__.'/api/store-groups.php';
});

Route::prefix('customers')->group(function () {
    require __DIR__.'/api/customers.php';
});

Route::prefix('customer-comptas')->group(function () {
    require __DIR__.'/api/customer-comptas.php';
});

Route::prefix('customer-stats')->group(function () {
    require __DIR__.'/api/customer-stats.php';
});