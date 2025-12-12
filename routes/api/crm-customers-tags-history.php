<?php

use App\Http\Controllers\Api\CrmCustomersTagsHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour l'historique des tags CRM des clients
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion de l'historique des tags CRM
|
*/

// GET /api/crm-customers-tags-history - Liste tout l'historique
Route::get('/', [CrmCustomersTagsHistoryController::class, 'index'])->name('crm-customers-tags-history.index');

// GET /api/crm-customers-tags-history/{id} - Affiche une entrée d'historique spécifique
Route::get('/{crm_customers_tags_history}', [CrmCustomersTagsHistoryController::class, 'show'])->name('crm-customers-tags-history.show');

// GET /api/crm-customers-tags-history/customer/{customerId} - Récupère l'historique d'un client spécifique
Route::get('/customer/{customerId}', [CrmCustomersTagsHistoryController::class, 'showByCustomer'])->name('crm-customers-tags-history.by-customer');

// GET /api/crm-customers-tags-history/tag/{tagId} - Récupère l'historique d'un tag spécifique
Route::get('/tag/{tagId}', [CrmCustomersTagsHistoryController::class, 'showByTag'])->name('crm-customers-tags-history.by-tag');

// GET /api/crm-customers-tags-history/recent/{days} - Récupère l'historique récent
Route::get('/recent/{days}', [CrmCustomersTagsHistoryController::class, 'showRecent'])->name('crm-customers-tags-history.recent');

// GET /api/crm-customers-tags-history/period/{startDate}/{endDate} - Récupère l'historique dans une période donnée
Route::get('/period/{startDate}/{endDate}', [CrmCustomersTagsHistoryController::class, 'showByPeriod'])->name('crm-customers-tags-history.period');

// POST /api/crm-customers-tags-history - Ajoute une nouvelle entrée à l'historique
Route::post('/', [CrmCustomersTagsHistoryController::class, 'store'])->name('crm-customers-tags-history.store');

// PUT /api/crm-customers-tags-history/{id} - Met à jour une entrée d'historique existante
Route::put('/{crm_customers_tags_history}', [CrmCustomersTagsHistoryController::class, 'update'])->name('crm-customers-tags-history.update');

// DELETE /api/crm-customers-tags-history/{id} - Supprime une entrée d'historique
Route::delete('/{crm_customers_tags_history}', [CrmCustomersTagsHistoryController::class, 'destroy'])->name('crm-customers-tags-history.destroy');

// DELETE /api/crm-customers-tags-history/customer/{customerId} - Supprime tout l'historique d'un client
Route::delete('/customer/{customerId}', [CrmCustomersTagsHistoryController::class, 'destroyByCustomer'])->name('crm-customers-tags-history.destroy-by-customer');