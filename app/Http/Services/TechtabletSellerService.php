<?php

namespace App\Http\Services;

use App\Models\TechtabletSeller;
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
            "id_seller" => $seller['id_techtablet_seller'],
            "name" => $seller['first_name'],
            "lastname" => $seller['last_name'],
            "phone1" => $seller['phone1'],
            "phone2" => $seller['phone2'],
            "post" => $seller['post'],
            "key" => $seller['key'],
            "sign" => $seller['signature'],
            "created_at" => $seller['created_at'],
            "updated_at" => $seller['updated_at'],
            "email" => $seller['email'],
            //auchan_preparator: "0",
            "active" => $seller['is_active']
        ];
        
        return (object)$data;
    }

    /**
     * Formate les données d'un vendeur de tablettes technologiques avec des informations supplémentaires pour le Customer Manager.
     *
     * @param array $seller Les données brutes du vendeur de tablettes technologiques
     * @return object Les données formatées avec des informations supplémentaires pour le Customer Manager
     */
    public static function format_data_with_more_info_for_customer_manager(Array $seller): Object
    {
        $data = [
            "success" => false,
            "sellerSuccess" => true,
            "seller" => self::format_data_for_customer_manager($seller),
            "customerSuccess" => false,
            "customer" => [],
            "error" => "customer doesn't exist or is assigned to another seller"
        ];
        
        return (object)$data;
    }
}