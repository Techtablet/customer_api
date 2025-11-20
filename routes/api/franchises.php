<?php

use App\Http\Controllers\Api\FranchiseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les franchises
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des franchises
|
*/

// GET /api/franchises - Liste toutes les franchises
Route::get('/', [FranchiseController::class, 'index'])->name('franchises.index');

// GET /api/franchises/{id} - Affiche une franchise spécifique
Route::get('/{franchise}', [FranchiseController::class, 'show'])->name('franchises.show');

// POST /api/franchises - Crée une nouvelle franchise
Route::post('/', [FranchiseController::class, 'store'])->name('franchises.store');

// PUT /api/franchises/{id} - Met à jour une franchise existante
Route::put('/{franchise}', [FranchiseController::class, 'update'])->name('franchises.update');

// DELETE /api/franchises/{id} - Supprime une franchise
Route::delete('/{franchise}', [FranchiseController::class, 'destroy'])->name('franchises.destroy');
