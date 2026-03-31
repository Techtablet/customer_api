<?php

namespace App\Http\Services;

use App\Models\CustomerCountry;
use Illuminate\Http\Request;

class CustomerCountryService
{
    /**
     * Formate les données d'un pays pour l'affichage dans le Customer Manager.
     *
     * @param array $country Les données brutes de la franchise
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $country): Object
    {
        $data = [
            "id" => $country['id_customer_country'],
            "id_country" => $country['id_customer_country'],
            "name" => $country['name'],
            "is_ue_export" => $country['is_ue_export'],
            "is_intracom_vat" => $country['is_intracom_vat'],
        ];

        
        return (object)$data;
    }

    /**
     * Formate les données d'un pays pour le shipping.
     *
     * @param array $country Les données brutes de la franchise
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_shipping(Array $country): Object
    {
        $data = [
            "id" => $country['id_customer_country'],
            "name" => $country['name'],
        ];

        
        return (object)$data;
    }
}