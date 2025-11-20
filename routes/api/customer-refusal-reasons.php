<?php

use App\Http\Controllers\Api\CustomerRefusalReasonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les raisons de refus clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des raisons de refus clients
|
*/

// GET /api/customer-refusal-reasons - Liste toutes les raisons de refus clients
Route::get('/', [CustomerRefusalReasonController::class, 'index'])->name('customer-refusal-reasons.index');

// GET /api/customer-refusal-reasons/{id} - Affiche une raison de refus client spécifique
Route::get('/{customer_refusal_reason}', [CustomerRefusalReasonController::class, 'show'])->name('customer-refusal-reasons.show');

// POST /api/customer-refusal-reasons - Crée une nouvelle raison de refus client
Route::post('/', [CustomerRefusalReasonController::class, 'store'])->name('customer-refusal-reasons.store');

// PUT /api/customer-refusal-reasons/{id} - Met à jour une raison de refus client existante
Route::put('/{customer_refusal_reason}', [CustomerRefusalReasonController::class, 'update'])->name('customer-refusal-reasons.update');

// DELETE /api/customer-refusal-reasons/{id} - Supprime une raison de refus client
Route::delete('/{customer_refusal_reason}', [CustomerRefusalReasonController::class, 'destroy'])->name('customer-refusal-reasons.destroy');