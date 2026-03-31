<?php

namespace App\Http\Services;

use App\Models\StockSoftware;
use Illuminate\Http\Request;

class StockSoftwareService
{
    /**
     * Formate les données d'un logiciel de stock pour l'affichage dans le Customer Manager.
     *
     * @param array $stockSoftware Les données brutes du logiciel de stock
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $stockSoftware): Object
    {
        $data = [
            "id" => $stockSoftware['id_stock_software'],
            "name" => $stockSoftware['name'],
        ];

        
        return (object)$data;
    }
}