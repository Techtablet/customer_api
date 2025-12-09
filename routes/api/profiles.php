<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les profils
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des profils
|
*/

// GET /api/profiles - Liste tous les profils
Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');

// GET /api/profiles/{id} - Affiche un profil spécifique
Route::get('/{profile}', [ProfileController::class, 'show'])->name('profiles.show');

// POST /api/profiles - Crée un nouveau profil
Route::post('/', [ProfileController::class, 'store'])->name('profiles.store');

// PUT /api/profiles/{id} - Met à jour un profil existant
Route::put('/{profile}', [ProfileController::class, 'update'])->name('profiles.update');

// DELETE /api/profiles/{id} - Supprime un profil
Route::delete('/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');