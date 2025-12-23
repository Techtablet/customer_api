<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     title="Pagination Metadata",
 *     description="Métadonnées de pagination",
 *     @OA\Property(
 *         property="current_page",
 *         type="integer",
 *         description="Page actuelle",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         type="integer",
 *         description="Nombre d'éléments par page",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="integer",
 *         description="Nombre total d'éléments",
 *         example=500
 *     ),
 *     @OA\Property(
 *         property="last_page",
 *         type="integer",
 *         description="Dernière page disponible",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="from",
 *         type="integer",
 *         description="Index du premier élément de la page",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="to",
 *         type="integer",
 *         description="Index du dernier élément de la page",
 *         example=100
 *     )
 * )
 */
class PaginationMeta
{
    // This class is only for Swagger documentation
}
