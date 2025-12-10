<?php

use App\Http\Controllers\Api\ShippingAddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes pour les adresses de livraison
|--------------------------------------------------------------------------
|
| Routes CRUD complètes pour la gestion des adresses de livraison
|
*/

// GET /api/shipping-addresses - Liste toutes les adresses de livraison
Route::get('/', [ShippingAddressController::class, 'index'])->name('shipping-addresses.index');

// GET /api/shipping-addresses/{id} - Affiche une adresse de livraison spécifique
Route::get('/{shipping_address}', [ShippingAddressController::class, 'show'])->name('shipping-addresses.show');

// GET /api/shipping-addresses/customer/{customerId} - Récupère les adresses de livraison d'un client spécifique
Route::get('/customer/{customerId}', [ShippingAddressController::class, 'showByCustomer'])->name('shipping-addresses.by-customer');

// GET /api/shipping-addresses/default - Récupère l'adresse de livraison par défaut
Route::get('/default', [ShippingAddressController::class, 'showDefault'])->name('shipping-addresses.default');

// POST /api/shipping-addresses - Crée une nouvelle adresse de livraison
Route::post('/', [ShippingAddressController::class, 'store'])->name('shipping-addresses.store');

// PUT /api/shipping-addresses/{id} - Met à jour une adresse de livraison existante
Route::put('/{shipping_address}', [ShippingAddressController::class, 'update'])->name('shipping-addresses.update');

// DELETE /api/shipping-addresses/{id} - Supprime une adresse de livraison
Route::delete('/{shipping_address}', [ShippingAddressController::class, 'destroy'])->name('shipping-addresses.destroy');