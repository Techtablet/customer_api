<?php

namespace App\Http\Services;

use App\Models\CustomerLocation;
use Illuminate\Http\Request;

class CustomerLocationService
{
    /**
     * Formate les données d'une localisation de client pour l'affichage dans le Customer Manager.
     *
     * @param array $customerLocation Les données brutes de la localisation de client
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $customerLocation): Object
    {
        $data = [
            "id" => $customerLocation['id_customer_location'],
            "name" => $customerLocation['name'],
        ];

        
        return (object)$data;
    }
}