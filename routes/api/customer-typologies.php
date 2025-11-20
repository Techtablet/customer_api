<?php

use App\Http\Controllers\Api\CustomerTypologyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les typologies clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des typologies clients
|
*/

// GET /api/customer-typologies - Liste toutes les typologies clients
Route::get('/', [CustomerTypologyController::class, 'index'])->name('customer-typologies.index');

// GET /api/customer-typologies/{id} - Affiche une typologie client spécifique
Route::get('/{customer_typology}', [CustomerTypologyController::class, 'show'])->name('customer-typologies.show');

// POST /api/customer-typologies - Crée une nouvelle typologie client
Route::post('/', [CustomerTypologyController::class, 'store'])->name('customer-typologies.store');

// PUT /api/customer-typologies/{id} - Met à jour une typologie client existante
Route::put('/{customer_typology}', [CustomerTypologyController::class, 'update'])->name('customer-typologies.update');

// DELETE /api/customer-typologies/{id} - Supprime une typologie client
Route::delete('/{customer_typology}', [CustomerTypologyController::class, 'destroy'])->name('customer-typologies.destroy');