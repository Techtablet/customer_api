<?php

namespace App\Http\Services;

use App\Models\CustomerLang;
use Illuminate\Http\Request;

class CustomerLangService
{
    /**
     * Formate les données d'une langue de client pour l'affichage dans le Customer Manager.
     *
     * @param array $customerLang Les données brutes de la langue de client
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $customerLang): Object
    {
        $data = [
            "id" => $customerLang['id_customer_lang'],
            "label" => $customerLang['name'],
            "code" => $customerLang['code_iso'],
        ];

        
        return (object)$data;
    }
}