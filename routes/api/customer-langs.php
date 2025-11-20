<?php

use App\Http\Controllers\Api\CustomerLangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les langues clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des langues clients
|
*/

// GET /api/customer-langs - Liste toutes les langues clients
Route::get('/', [CustomerLangController::class, 'index'])->name('customer-langs.index');

// GET /api/customer-langs/{id} - Affiche une langue client spécifique
Route::get('/{customer_lang}', [CustomerLangController::class, 'show'])->name('customer-langs.show');

// POST /api/customer-langs - Crée une nouvelle langue client
Route::post('/', [CustomerLangController::class, 'store'])->name('customer-langs.store');

// PUT /api/customer-langs/{id} - Met à jour une langue client existante
Route::put('/{customer_lang}', [CustomerLangController::class, 'update'])->name('customer-langs.update');

// DELETE /api/customer-langs/{id} - Supprime une langue client
Route::delete('/{customer_lang}', [CustomerLangController::class, 'destroy'])->name('customer-langs.destroy');