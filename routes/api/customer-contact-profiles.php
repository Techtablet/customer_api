<?php

use App\Http\Controllers\Api\CustomerContactProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les liaisons profils-contacts
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des liaisons entre profils et contacts clients
|
*/

// GET /api/customer-contact-profiles - Liste toutes les liaisons
Route::get('/', [CustomerContactProfileController::class, 'index'])->name('customer-contact-profiles.index');

// GET /api/customer-contact-profiles/{id} - Affiche une liaison spécifique
Route::get('/{customer_contact_profile}', [CustomerContactProfileController::class, 'show'])->name('customer-contact-profiles.show');

// GET /api/customer-contact-profiles/profile/{profileId} - Récupère les liaisons pour un profil spécifique
Route::get('/profile/{profileId}', [CustomerContactProfileController::class, 'showByProfile'])->name('customer-contact-profiles.by-profile');

// GET /api/customer-contact-profiles/contact/{contactId} - Récupère les liaisons pour un contact spécifique
Route::get('/contact/{contactId}', [CustomerContactProfileController::class, 'showByContact'])->name('customer-contact-profiles.by-contact');

// POST /api/customer-contact-profiles - Crée une nouvelle liaison
Route::post('/', [CustomerContactProfileController::class, 'store'])->name('customer-contact-profiles.store');

// PUT /api/customer-contact-profiles/{id} - Met à jour une liaison existante
Route::put('/{customer_contact_profile}', [CustomerContactProfileController::class, 'update'])->name('customer-contact-profiles.update');

// DELETE /api/customer-contact-profiles/{id} - Supprime une liaison
Route::delete('/{customer_contact_profile}', [CustomerContactProfileController::class, 'destroy'])->name('customer-contact-profiles.destroy');