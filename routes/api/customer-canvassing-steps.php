<?php

use App\Http\Controllers\Api\CustomerCanvassingStepController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les étapes de démarchage clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des étapes de démarchage clients
|
*/

// GET /api/customer-canvassing-steps - Liste toutes les étapes de démarchage clients
Route::get('/', [CustomerCanvassingStepController::class, 'index'])->name('customer-canvassing-steps.index');

// GET /api/customer-canvassing-steps/{id} - Affiche une étape de démarchage client spécifique
Route::get('/{customer_canvassing_step}', [CustomerCanvassingStepController::class, 'show'])->name('customer-canvassing-steps.show');

// POST /api/customer-canvassing-steps - Crée une nouvelle étape de démarchage client
Route::post('/', [CustomerCanvassingStepController::class, 'store'])->name('customer-canvassing-steps.store');

// PUT /api/customer-canvassing-steps/{id} - Met à jour une étape de démarchage client existante
Route::put('/{customer_canvassing_step}', [CustomerCanvassingStepController::class, 'update'])->name('customer-canvassing-steps.update');

// DELETE /api/customer-canvassing-steps/{id} - Supprime une étape de démarchage client
Route::delete('/{customer_canvassing_step}', [CustomerCanvassingStepController::class, 'destroy'])->name('customer-canvassing-steps.destroy');