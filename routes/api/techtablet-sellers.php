<?php

use App\Http\Controllers\Api\TechtabletSellerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les vendeurs Techtablet
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des vendeurs Techtablet
|
*/

// GET /api/techtablet-sellers - Liste tous les vendeurs Techtablet
Route::get('/', [TechtabletSellerController::class, 'index'])->name('techtablet-sellers.index');

// GET /api/techtablet-sellers/{id} - Affiche un vendeur Techtablet spécifique
Route::get('/{techtablet_seller}', [TechtabletSellerController::class, 'show'])->name('techtablet-sellers.show');

// POST /api/techtablet-sellers - Crée un nouveau vendeur Techtablet
Route::post('/', [TechtabletSellerController::class, 'store'])->name('techtablet-sellers.store');

// PUT /api/techtablet-sellers/{id} - Met à jour un vendeur Techtablet existant
Route::put('/{techtablet_seller}', [TechtabletSellerController::class, 'update'])->name('techtablet-sellers.update');

// DELETE /api/techtablet-sellers/{id} - Supprime un vendeur Techtablet
Route::delete('/{techtablet_seller}', [TechtabletSellerController::class, 'destroy'])->name('techtablet-sellers.destroy');