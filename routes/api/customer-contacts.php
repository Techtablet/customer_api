<?php

use App\Http\Controllers\Api\CustomerContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les contacts clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des contacts clients
|
*/

// GET /api/customer-contacts - Liste tous les contacts clients
Route::get('/', [CustomerContactController::class, 'index'])->name('customer-contacts.index');

// GET /api/customer-contacts/{id} - Affiche un contact client spécifique
Route::get('/{customer_contact}', [CustomerContactController::class, 'show'])->name('customer-contacts.show');

// GET /api/customer-contacts/customer/{customerId} - Récupère les contacts d'un client spécifique
Route::get('/customer/{customerId}', [CustomerContactController::class, 'showByCustomer'])->name('customer-contacts.by-customer');

// GET /api/customer-contacts/customer/{customerId}/default - Récupère le contact par défaut d'un client
Route::get('/customer/{customerId}/default', [CustomerContactController::class, 'showDefaultByCustomer'])->name('customer-contacts.default-by-customer');

// POST /api/customer-contacts - Crée un nouveau contact client
Route::post('/', [CustomerContactController::class, 'store'])->name('customer-contacts.store');

// PUT /api/customer-contacts/{id} - Met à jour un contact client existant
Route::put('/{customer_contact}', [CustomerContactController::class, 'update'])->name('customer-contacts.update');

// DELETE /api/customer-contacts/{id} - Supprime un contact client
Route::delete('/{customer_contact}', [CustomerContactController::class, 'destroy'])->name('customer-contacts.destroy');