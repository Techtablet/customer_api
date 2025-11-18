<?php

use Illuminate\Support\Facades\Route;

// Inclusion des routes spécifiques à CustomerStatus
Route::prefix('customer-statuses')->group(function () {
    require __DIR__.'/api/customer_status.php';
});
