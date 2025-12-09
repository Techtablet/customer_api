<?php

use App\Http\Controllers\Api\StoreGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les groupes de magasins
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des groupes de magasins
|
*/

// GET /api/store-groups - Liste tous les groupes de magasins
Route::get('/', [StoreGroupController::class, 'index'])->name('store-groups.index');

// GET /api/store-groups/{id} - Affiche un groupe de magasins spécifique
Route::get('/{store_group}', [StoreGroupController::class, 'show'])->name('store-groups.show');

// POST /api/store-groups - Crée un nouveau groupe de magasins
Route::post('/', [StoreGroupController::class, 'store'])->name('store-groups.store');

// PUT /api/store-groups/{id} - Met à jour un groupe de magasins existant
Route::put('/{store_group}', [StoreGroupController::class, 'update'])->name('store-groups.update');

// DELETE /api/store-groups/{id} - Supprime un groupe de magasins
Route::delete('/{store_group}', [StoreGroupController::class, 'destroy'])->name('store-groups.destroy');