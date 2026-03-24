<?php

namespace App\Http\Services;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerService
{
    public static function format_data_for_customer_manager(Array $customer): Object
    {
        dd($customer);
        
        $data = [
            "id"=> $customer['id_customer'],
            //"token"=> $customer['id_customer'] ?? null,
            "name"=> $customer['name'],
            //"delivery_name"=> "Telephone Store (Morestel)",
            "featured_product"=> $customer['featured_product'],
            
            
            "phones"=> [
                "04 28 35 03 51",
                "04 74 28 94 61"
            ],
            "email"=> "arminaud@techtablet.fr",
            "key"=> "AmS25vt7",
            "status"=> (object) [
                "id"=> "1",
                "name"=> "Ouvert",
                "color"=> "vert"
            ],
            "seller"=> (object) [
                "id_seller"=> "8",
                "name"=> "Camille",
                "phone1"=> "+33 4 82 82 61 81"
            ]
        ];

        if(isset($customer['shipping_addresse_default'])) {
            $data["address_shipping"] = (object) [
                "id_adress"=> 7,
                "named"=> "Coriolis Telecom \/ Numeriks (Morestel)",
                "firstname"=> "Romain",
                "lastname"=> "Mogenot",
                "street"=> "81 Grande Rue",
                "complement_adress"=> null,
                "postcode"=> "38510",
                "city"=> "Morestel",
                "country"=> "France",
                "country_obj"=> (object) [
                    "id"=> 1,
                    "name"=> "France",
                    "isocode"=> "FR"
                ],
                "phone"=> "",
                "fax"=> "",
                "iso_code"=> "FR",
                "default"=> "1",
                "difficult_access"=> (object) [
                    "value"=> "0",
                    "display"=> "false"
                ],
                "lng"=> "5.4699085",
                "lat"=> "45.6771519",
                "place_id"=> "ChIJS7xD3XI8i0cRg3Gb1uWRh7c"
            ];
        }

        if(isset($customer['invoice_address'])) {
            $data["address_billing"] = (object) [
                "firstname"=> "Romain",
                "lastname"=> "Mogenot",
                "street"=> "2 rue Joseph Seigner",
                "postcode"=> "38300",
                "city"=> "Bourgoin-Jallieu",
                "country"=> "France",
                "phone"=> "",
                "fax"=> "",
                "email"=> "arminaud@techtablet.fr",
                "iso_code"=> "FR",
                "ccn3"=> "250",
                "dial_code"=> "+33",
                "lng"=> "5.2777389",
                "lat"=> "45.5872210",
                "place_id"=> "ChIJg-GqEIQui0cRnd3yJUxrYiE"
            ];
        }
        dd($data);
        return $data;
    }
}