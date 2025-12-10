<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="InvoiceAddress",
 *     type="object",
 *     title="InvoiceAddress",
 *     description="Modèle d'adresse de facturation",
 *     @OA\Property(
 *         property="id_invoice_address",
 *         type="integer",
 *         description="ID unique de l'adresse de facturation",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer_address",
 *         type="integer",
 *         description="ID de l'adresse client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière modification"
 *     )
 * )
 */
class InvoiceAddress extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'invoice_addresses';

    /**
     * La clé primaire associée à la table.
     *
     * @var string
     */
    protected $primaryKey = 'id_invoice_address';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_customer_address',
        'id_customer',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation avec le modèle CustomerAddress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'id_customer_address', 'id_customer_address');
    }

    /**
     * Relation avec le modèle Customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}