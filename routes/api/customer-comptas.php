<?php

use App\Http\Controllers\Api\CustomerComptaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les comptabilités clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des comptabilités clients
|
*/

// GET /api/customer-comptas - Liste toutes les comptabilités clients
Route::get('/', [CustomerComptaController::class, 'index'])->name('customer-comptas.index');

// GET /api/customer-comptas/{id} - Affiche une comptabilité client spécifique
Route::get('/{customer_compta}', [CustomerComptaController::class, 'show'])->name('customer-comptas.show');

// GET /api/customer-comptas/customer/{customerId} - Récupère la comptabilité d'un client spécifique
Route::get('/customer/{customerId}', [CustomerComptaController::class, 'showByCustomer'])->name('customer-comptas.by-customer');

// POST /api/customer-comptas - Crée une nouvelle comptabilité client
Route::post('/', [CustomerComptaController::class, 'store'])->name('customer-comptas.store');

// PUT /api/customer-comptas/{id} - Met à jour une comptabilité client existante
Route::put('/{customer_compta}', [CustomerComptaController::class, 'update'])->name('customer-comptas.update');

// DELETE /api/customer-comptas/{id} - Supprime une comptabilité client
Route::delete('/{customer_compta}', [CustomerComptaController::class, 'destroy'])->name('customer-comptas.destroy');