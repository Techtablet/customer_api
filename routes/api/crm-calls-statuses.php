<?php

use App\Http\Controllers\Api\CrmCallsStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les statuts d'appels CRM
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des statuts d'appels CRM
|
*/

// GET /api/crm-calls-statuses - Liste tous les statuts d'appels CRM
Route::get('/', [CrmCallsStatusController::class, 'index'])->name('crm-calls-statuses.index');

// GET /api/crm-calls-statuses/{id} - Affiche un statut d'appel CRM spécifique
Route::get('/{crm_calls_status}', [CrmCallsStatusController::class, 'show'])->name('crm-calls-statuses.show');

// GET /api/crm-calls-statuses/search/{name} - Recherche des statuts d'appels CRM par nom
Route::get('/search/{name}', [CrmCallsStatusController::class, 'search'])->name('crm-calls-statuses.search');

// POST /api/crm-calls-statuses - Crée un nouveau statut d'appel CRM
Route::post('/', [CrmCallsStatusController::class, 'store'])->name('crm-calls-statuses.store');

// PUT /api/crm-calls-statuses/{id} - Met à jour un statut d'appel CRM existant
Route::put('/{crm_calls_status}', [CrmCallsStatusController::class, 'update'])->name('crm-calls-statuses.update');

// DELETE /api/crm-calls-statuses/{id} - Supprime un statut d'appel CRM
Route::delete('/{crm_calls_status}', [CrmCallsStatusController::class, 'destroy'])->name('crm-calls-statuses.destroy');