<?php

namespace App\Http\Services;

use App\Models\CustomerTypology;
use Illuminate\Http\Request;

class CustomerTypologyService
{
    /**
     * Formate les données d'une typologie de client pour l'affichage dans le Customer Manager.
     *
     * @param array $typology Les données brutes de la typologie de client
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $typology): Object
    {
        $data = [
            "id" => $typology['id_customer_typology'],
            "name" => $typology['name'],
        ];

        
        return (object)$data;
    }
}