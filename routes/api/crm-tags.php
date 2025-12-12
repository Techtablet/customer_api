<?php

use App\Http\Controllers\Api\CrmTagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les tags CRM
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des tags CRM
|
*/

// GET /api/crm-tags - Liste tous les tags CRM
Route::get('/', [CrmTagController::class, 'index'])->name('crm-tags.index');

// GET /api/crm-tags/active - Liste tous les tags CRM actifs
Route::get('/active', [CrmTagController::class, 'indexActive'])->name('crm-tags.active');

// GET /api/crm-tags/inactive - Liste tous les tags CRM inactifs
Route::get('/inactive', [CrmTagController::class, 'indexInactive'])->name('crm-tags.inactive');

// GET /api/crm-tags/{id} - Affiche un tag CRM spécifique
Route::get('/{crm_tag}', [CrmTagController::class, 'show'])->name('crm-tags.show');

// POST /api/crm-tags - Crée un nouveau tag CRM
Route::post('/', [CrmTagController::class, 'store'])->name('crm-tags.store');

// PUT /api/crm-tags/{id} - Met à jour un tag CRM existant
Route::put('/{crm_tag}', [CrmTagController::class, 'update'])->name('crm-tags.update');

// DELETE /api/crm-tags/{id} - Supprime un tag CRM
Route::delete('/{crm_tag}', [CrmTagController::class, 'destroy'])->name('crm-tags.destroy');

// PATCH /api/crm-tags/{id}/activate - Active un tag CRM
Route::patch('/{crm_tag}/activate', [CrmTagController::class, 'activate'])->name('crm-tags.activate');

// PATCH /api/crm-tags/{id}/deactivate - Désactive un tag CRM
Route::patch('/{crm_tag}/deactivate', [CrmTagController::class, 'deactivate'])->name('crm-tags.deactivate');