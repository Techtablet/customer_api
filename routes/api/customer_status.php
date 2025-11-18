<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerStatusController;

Route::get('/', [CustomerStatusController::class, 'index'])->name('customer-status.index');
Route::post('/', [CustomerStatusController::class, 'store'])->name('customer-status.store');
Route::get('/{customerStatus}', [CustomerStatusController::class, 'show'])->name('customer-status.show');
Route::put('/{customerStatus}', [CustomerStatusController::class, 'update'])->name('customer-status.update');
Route::delete('/{customerStatus}', [CustomerStatusController::class, 'destroy'])->name('customer-status.destroy');
