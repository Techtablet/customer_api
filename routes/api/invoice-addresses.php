<?php

use App\Http\Controllers\Api\InvoiceAddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les adresses de facturation
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des adresses de facturation
|
*/

// GET /api/invoice-addresses - Liste toutes les adresses de facturation
Route::get('/', [InvoiceAddressController::class, 'index'])->name('invoice-addresses.index');

// GET /api/invoice-addresses/{id} - Affiche une adresse de facturation spécifique
Route::get('/{invoice_address}', [InvoiceAddressController::class, 'show'])->name('invoice-addresses.show');

// GET /api/invoice-addresses/customer/{customerId} - Récupère l'adresse de facturation d'un client spécifique
Route::get('/customer/{customerId}', [InvoiceAddressController::class, 'showByCustomer'])->name('invoice-addresses.by-customer');

// POST /api/invoice-addresses - Crée une nouvelle adresse de facturation
Route::post('/', [InvoiceAddressController::class, 'store'])->name('invoice-addresses.store');

// PUT /api/invoice-addresses/{id} - Met à jour une adresse de facturation existante
Route::put('/{invoice_address}', [InvoiceAddressController::class, 'update'])->name('invoice-addresses.update');

// DELETE /api/invoice-addresses/{id} - Supprime une adresse de facturation
Route::delete('/{invoice_address}', [InvoiceAddressController::class, 'destroy'])->name('invoice-addresses.destroy');