<?php

use App\Http\Controllers\Api\CustomerAddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les adresses clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des adresses clients
|
*/

// GET /api/customer-addresses - Liste toutes les adresses clients
Route::get('/', [CustomerAddressController::class, 'index'])->name('customer-addresses.index');

// GET /api/customer-addresses/{id} - Affiche une adresse client spécifique
Route::get('/{customer_address}', [CustomerAddressController::class, 'show'])->name('customer-addresses.show');

// POST /api/customer-addresses - Crée une nouvelle adresse client
Route::post('/', [CustomerAddressController::class, 'store'])->name('customer-addresses.store');

// PUT /api/customer-addresses/{id} - Met à jour une adresse client existante
Route::put('/{customer_address}', [CustomerAddressController::class, 'update'])->name('customer-addresses.update');

// DELETE /api/customer-addresses/{id} - Supprime une adresse client
Route::delete('/{customer_address}', [CustomerAddressController::class, 'destroy'])->name('customer-addresses.destroy');