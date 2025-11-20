<?php

use App\Http\Controllers\Api\CustomerLocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les localisations clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des localisations clients
|
*/

// GET /api/customer-locations - Liste toutes les localisations clients
Route::get('/', [CustomerLocationController::class, 'index'])->name('customer-locations.index');

// GET /api/customer-locations/{id} - Affiche une localisation client spécifique
Route::get('/{customer_location}', [CustomerLocationController::class, 'show'])->name('customer-locations.show');

// POST /api/customer-locations - Crée une nouvelle localisation client
Route::post('/', [CustomerLocationController::class, 'store'])->name('customer-locations.store');

// PUT /api/customer-locations/{id} - Met à jour une localisation client existante
Route::put('/{customer_location}', [CustomerLocationController::class, 'update'])->name('customer-locations.update');

// DELETE /api/customer-locations/{id} - Supprime une localisation client
Route::delete('/{customer_location}', [CustomerLocationController::class, 'destroy'])->name('customer-locations.destroy');