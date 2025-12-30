<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les utilisateurs
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des utilisateurs
|
*/

// GET /api/users - Liste tous les utilisateurs
Route::get('/', [UserController::class, 'index'])->name('users.index');

// GET /api/users/admins - Liste tous les administrateurs
Route::get('/admins', [UserController::class, 'indexAdmins'])->name('users.admins');

// GET /api/users/customers - Liste tous les clients
Route::get('/customers', [UserController::class, 'indexCustomers'])->name('users.customers');

// GET /api/users/{id} - Affiche un utilisateur spécifique
Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

// GET /api/users/email/{email} - Recherche un utilisateur par email
Route::get('/email/{email}', [UserController::class, 'findByEmail'])->name('users.find-by-email');

// POST /api/users - Crée un nouvel utilisateur
Route::post('/', [UserController::class, 'store'])->name('users.store');

// PUT /api/users/{id} - Met à jour un utilisateur existant
Route::put('/{user}', [UserController::class, 'update'])->name('users.update');

// DELETE /api/users/{id} - Supprime un utilisateur
Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// PATCH /api/users/{id}/verify-email - Vérifie l'email d'un utilisateur
Route::patch('/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');

// PATCH /api/users/{id}/change-password - Change le mot de passe d'un utilisateur
Route::patch('/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');