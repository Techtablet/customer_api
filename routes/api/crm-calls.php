<?php

use App\Http\Controllers\Api\CrmCallController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les appels CRM
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des appels CRM
|
*/

// GET /api/crm-calls - Liste tous les appels CRM
Route::get('/', [CrmCallController::class, 'index'])->name('crm-calls.index');

// GET /api/crm-calls/{id} - Affiche un appel CRM spécifique
Route::get('/{crm_call}', [CrmCallController::class, 'show'])->name('crm-calls.show');

// GET /api/crm-calls/customer/{customerId} - Récupère les appels d'un client spécifique
Route::get('/customer/{customerId}', [CrmCallController::class, 'showByCustomer'])->name('crm-calls.by-customer');

// GET /api/crm-calls/seller/{sellerId} - Récupère les appels d'un commercial spécifique
Route::get('/seller/{sellerId}', [CrmCallController::class, 'showBySeller'])->name('crm-calls.by-seller');

// GET /api/crm-calls/status/{statusId} - Récupère les appels avec un statut spécifique
Route::get('/status/{statusId}', [CrmCallController::class, 'showByStatus'])->name('crm-calls.by-status');

// GET /api/crm-calls/recent/{days} - Récupère les appels récents
Route::get('/recent/{days}', [CrmCallController::class, 'showRecent'])->name('crm-calls.recent');

// POST /api/crm-calls - Crée un nouvel appel CRM
Route::post('/', [CrmCallController::class, 'store'])->name('crm-calls.store');

// PUT /api/crm-calls/{id} - Met à jour un appel CRM existant
Route::put('/{crm_call}', [CrmCallController::class, 'update'])->name('crm-calls.update');

// DELETE /api/crm-calls/{id} - Supprime un appel CRM
Route::delete('/{crm_call}', [CrmCallController::class, 'destroy'])->name('crm-calls.destroy');

// PATCH /api/crm-calls/{id}/mark-shipping-done - Marque l'expédition comme faite
Route::patch('/{crm_call}/mark-shipping-done', [CrmCallController::class, 'markShippingDone'])->name('crm-calls.mark-shipping-done');

// PATCH /api/crm-calls/{id}/mark-shipping-undone - Marque l'expédition comme non faite
Route::patch('/{crm_call}/mark-shipping-undone', [CrmCallController::class, 'markShippingUndone'])->name('crm-calls.mark-shipping-undone');