<?php

use App\Http\Controllers\Api\CustomerStatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les statistiques clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des statistiques clients
|
*/

// GET /api/customer-stats - Liste toutes les statistiques clients
Route::get('/', [CustomerStatController::class, 'index'])->name('customer-stats.index');

// GET /api/customer-stats/{id} - Affiche les statistiques d'un client spécifique
Route::get('/{customer_stat}', [CustomerStatController::class, 'show'])->name('customer-stats.show');

// POST /api/customer-stats - Crée de nouvelles statistiques client
Route::post('/', [CustomerStatController::class, 'store'])->name('customer-stats.store');

// PUT /api/customer-stats/{id} - Met à jour les statistiques d'un client existant
Route::put('/{customer_stat}', [CustomerStatController::class, 'update'])->name('customer-stats.update');

// DELETE /api/customer-stats/{id} - Supprime les statistiques d'un client
Route::delete('/{customer_stat}', [CustomerStatController::class, 'destroy'])->name('customer-stats.destroy');