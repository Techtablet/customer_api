<?php

namespace App\Http\Services;

use App\Models\Franchise;
use Illuminate\Http\Request;

class FranchiseService
{
    /**
     * Formate les données d'une franchise pour l'affichage dans le Customer Manager.
     *
     * @param array $franchise Les données brutes de la franchise
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $franchise): Object
    {
        $data = [
            "id" => $franchise['id_franchise'],
            "name" => $franchise['name'],
        ];

        
        return (object)$data;
    }
}