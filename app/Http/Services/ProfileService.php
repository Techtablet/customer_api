<?php

namespace App\Http\Services;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileService
{
    /**
     * Formate les données d'un profil pour l'affichage dans le Customer Manager.
     *
     * @param array $profile Les données brutes du profil
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $profile): Object
    {
        $data = [
            "id" => $profile['id_profile'],
            "name" => $profile['name'],
        ];

        
        return (object)$data;
    }
}