<?php

use App\Http\Controllers\Api\CustomerContactRoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les rôles de contacts clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des rôles de contacts clients
|
*/

// GET /api/customer-contact-roles - Liste tous les rôles de contacts clients
Route::get('/', [CustomerContactRoleController::class, 'index'])->name('customer-contact-roles.index');

// GET /api/customer-contact-roles/{id} - Affiche un rôle de contact client spécifique
Route::get('/{customer_contact_role}', [CustomerContactRoleController::class, 'show'])->name('customer-contact-roles.show');

// POST /api/customer-contact-roles - Crée un nouveau rôle de contact client
Route::post('/', [CustomerContactRoleController::class, 'store'])->name('customer-contact-roles.store');

// PUT /api/customer-contact-roles/{id} - Met à jour un rôle de contact client existant
Route::put('/{customer_contact_role}', [CustomerContactRoleController::class, 'update'])->name('customer-contact-roles.update');

// DELETE /api/customer-contact-roles/{id} - Supprime un rôle de contact client
Route::delete('/{customer_contact_role}', [CustomerContactRoleController::class, 'destroy'])->name('customer-contact-roles.destroy');