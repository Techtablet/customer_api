<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockSoftwareController;

Route::get('/', [StockSoftwareController::class, 'index'])->name('stock-software.index');

Route::post('/', [StockSoftwareController::class, 'store'])->name('stock-software.store');

Route::get('/{stockSoftware}', [StockSoftwareController::class, 'show'])->name('stock-software.show');

Route::put('/{stockSoftware}', [StockSoftwareController::class, 'update'])->name('stock-software.update');

Route::delete('/{stockSoftware}', [StockSoftwareController::class, 'destroy'])->name('stock-software.destroy');
