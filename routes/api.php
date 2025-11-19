<?php

use Illuminate\Support\Facades\Route;

Route::prefix('customer-statuses')->group(function () {
    require __DIR__.'/api/customer_status.php';
});

Route::prefix('stock-softwares')->group(function () {
    require __DIR__.'/api/stock_software.php';
});

