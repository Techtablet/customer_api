<?php

use App\Http\Controllers\Api\CrmCustomersTagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les liaisons clients-tags CRM
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des liaisons entre clients et tags CRM
|
*/

// GET /api/crm-customers-tags - Liste toutes les liaisons
Route::get('/', [CrmCustomersTagController::class, 'index'])->name('crm-customers-tags.index');

// GET /api/crm-customers-tags/{id} - Affiche une liaison spécifique
Route::get('/{crm_customers_tag}', [CrmCustomersTagController::class, 'show'])->name('crm-customers-tags.show');

// GET /api/crm-customers-tags/customer/{customerId} - Récupère les tags d'un client spécifique
Route::get('/customer/{customerId}', [CrmCustomersTagController::class, 'showByCustomer'])->name('crm-customers-tags.by-customer');

// GET /api/crm-customers-tags/tag/{tagId} - Récupère les clients ayant un tag spécifique
Route::get('/tag/{tagId}', [CrmCustomersTagController::class, 'showByTag'])->name('crm-customers-tags.by-tag');

// POST /api/crm-customers-tags - Crée une nouvelle liaison
Route::post('/', [CrmCustomersTagController::class, 'store'])->name('crm-customers-tags.store');

// PUT /api/crm-customers-tags/{id} - Met à jour une liaison existante
Route::put('/{crm_customers_tag}', [CrmCustomersTagController::class, 'update'])->name('crm-customers-tags.update');

// DELETE /api/crm-customers-tags/{id} - Supprime une liaison
Route::delete('/{crm_customers_tag}', [CrmCustomersTagController::class, 'destroy'])->name('crm-customers-tags.destroy');

// DELETE /api/crm-customers-tags/customer/{customerId}/tag/{tagId} - Supprime une liaison spécifique par client et tag
Route::delete('/customer/{customerId}/tag/{tagId}', [CrmCustomersTagController::class, 'destroyByCustomerAndTag'])->name('crm-customers-tags.destroy-by-customer-tag');