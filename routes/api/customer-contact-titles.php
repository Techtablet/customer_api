<?php

use App\Http\Controllers\Api\CustomerContactTitleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les civilités clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des civilités clients
|
*/

// GET /api/customer-contact-titles - Liste toutes les civilités clients
Route::get('/', [CustomerContactTitleController::class, 'index'])->name('customer-contact-titles.index');

// GET /api/customer-contact-titles/{id} - Affiche une civilité client spécifique
Route::get('/{customer_contact_title}', [CustomerContactTitleController::class, 'show'])->name('customer-contact-titles.show');

// POST /api/customer-contact-titles - Crée une nouvelle civilité client
Route::post('/', [CustomerContactTitleController::class, 'store'])->name('customer-contact-titles.store');

// PUT /api/customer-contact-titles/{id} - Met à jour une civilité client existante
Route::put('/{customer_contact_title}', [CustomerContactTitleController::class, 'update'])->name('customer-contact-titles.update');

// DELETE /api/customer-contact-titles/{id} - Supprime une civilité client
Route::delete('/{customer_contact_title}', [CustomerContactTitleController::class, 'destroy'])->name('customer-contact-titles.destroy');