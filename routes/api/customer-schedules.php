<?php

use App\Http\Controllers\Api\CustomerScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les horaires clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des horaires clients
|
*/

// GET /api/customer-schedules - Liste tous les horaires clients
Route::get('/', [CustomerScheduleController::class, 'index'])->name('customer-schedules.index');

// GET /api/customer-schedules/{id} - Affiche un horaire client spécifique
Route::get('/{customer_schedule}', [CustomerScheduleController::class, 'show'])->name('customer-schedules.show');

// GET /api/customer-schedules/customer/{customerId} - Récupère les horaires d'un client spécifique
Route::get('/customer/{customerId}', [CustomerScheduleController::class, 'showByCustomer'])->name('customer-schedules.by-customer');

// GET /api/customer-schedules/day/{day} - Récupère les horaires pour un jour spécifique
Route::get('/day/{day}', [CustomerScheduleController::class, 'showByDay'])->name('customer-schedules.by-day');

// GET /api/customer-schedules/currently-open - Récupère les clients actuellement ouverts
Route::get('/currently-open', [CustomerScheduleController::class, 'showCurrentlyOpen'])->name('customer-schedules.currently-open');

// POST /api/customer-schedules - Crée un nouvel horaire client
Route::post('/', [CustomerScheduleController::class, 'store'])->name('customer-schedules.store');

// PUT /api/customer-schedules/{id} - Met à jour un horaire client existant
Route::put('/{customer_schedule}', [CustomerScheduleController::class, 'update'])->name('customer-schedules.update');

// DELETE /api/customer-schedules/{id} - Supprime un horaire client
Route::delete('/{customer_schedule}', [CustomerScheduleController::class, 'destroy'])->name('customer-schedules.destroy');