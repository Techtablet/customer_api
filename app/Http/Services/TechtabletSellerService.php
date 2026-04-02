<?php

namespace App\Http\Services;

use App\Models\Franchise;
use Illuminate\Http\Request;

class TechtabletSellerService
{
    /**
     * Formate les données d'un vendeur de tablettes technologiques pour l'affichage dans le Customer Manager.
     *
     * @param array $franchise Les données brutes du vendeur de tablettes technologiques
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $seller): Object
    {
        $data = [
            "id" => $seller['id_seller'],
            "name" => $seller['name'],
        ];

        
        return (object)$data;
    }
}