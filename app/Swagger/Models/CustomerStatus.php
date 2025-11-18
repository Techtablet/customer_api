<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema(
 *     schema="CustomerStatus",
 *     type="object",
 *     title="CustomerStatus",
 *     description="Représente un statut client",
 *     @OA\Property(property="id_customer_status", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Actif"),
 *     @OA\Property(property="color", type="string", example="#00FF00")
 * )
 */
class CustomerStatus
{
    // Ce fichier ne contient que la définition du schéma pour Swagger.
}
