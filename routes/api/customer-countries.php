<?php

use App\Http\Controllers\Api\CustomerCountryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les pays clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des pays clients
|
*/

// GET /api/customer-countries - Liste tous les pays clients
Route::get('/', [CustomerCountryController::class, 'index'])->name('customer-countries.index');

// GET /api/customer-countries/{id} - Affiche un pays client spécifique
Route::get('/{customer_country}', [CustomerCountryController::class, 'show'])->name('customer-countries.show');

// POST /api/customer-countries - Crée un nouveau pays client
Route::post('/', [CustomerCountryController::class, 'store'])->name('customer-countries.store');

// PUT /api/customer-countries/{id} - Met à jour un pays client existant
Route::put('/{customer_country}', [CustomerCountryController::class, 'update'])->name('customer-countries.update');

// DELETE /api/customer-countries/{id} - Supprime un pays client
Route::delete('/{customer_country}', [CustomerCountryController::class, 'destroy'])->name('customer-countries.destroy');
