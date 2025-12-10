<?php

use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des clients
|
*/

// GET /api/customers - Liste tous les clients
Route::get('/', [CustomerController::class, 'index'])->name('customers.index');

// GET /api/customers/{id} - Affiche un client spécifique
Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');

// POST /api/customers - Crée un nouveau client
Route::post('/', [CustomerController::class, 'store'])->name('customers.store');

// PUT /api/customers/{id} - Met à jour un client existant
Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');

// DELETE /api/customers/{id} - Supprime un client
Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');