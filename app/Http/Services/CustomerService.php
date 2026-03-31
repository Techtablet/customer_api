<?php

namespace App\Http\Services;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerService
{
    /**
     * Formate les données d'un client pour l'affichage dans le Customer Manager.
     *
     * @param array $customer Les données brutes du client
     * @return object Les données formatées pour le Customer Manager
     */
    public static function format_data_for_customer_manager(Array $customer): Object
    {
        $data = [
            "id" => $customer['id_customer'],
            "name" => $customer['name'],
            "delivery_name"=> "Telephone Store (Morestel)",
            "featured_product" => $customer['featured_product'],
        ];

        if (isset($customer['user'])) {
            $data["email"] = $customer['user']['email'];
            $data["key"] = $customer['user']['user_key'];
            $data["token"] = "5ee5fbec8741378b15a1e525480eaaa5";
        }

        if(isset($customer['status'])) {
            $data["status"] = (object) [
                "id" => $customer['status']['id_customer_status'],
                "name" => $customer['status']['name'],
                "color" => $customer['status']['color']
            ];
        }

        if(isset($customer['seller'])) {
            $data["seller"] = (object) [
                "id_seller" => $customer['seller']["id_techtablet_seller"],
                "name" => $customer['seller']["first_name"]." ".$customer['seller']["last_name"],
                "phone1" => $customer['seller']["phone1"]
            ];
        }

        // default contact
        if(isset($customer['contact_default']) && count($customer['contact_default']) > 0) {
            $phones = [];
            if ($customer['contact_default'][0]["phone_number"]) {
                $phones[] = $customer['contact_default'][0]["phone_number"];
            }
            if ($customer['contact_default'][0]["phone_number_2"]) {
                $phones[] = $customer['contact_default'][0]["phone_number_2"];
            }
            $data["phones"] = $phones;
        }

        // default shipping address
        if(isset($customer['shipping_addresses'])) {
            $address_shipping = [];
            foreach ($customer['shipping_addresses'] as $shipping_address) {
                $address_shipping [] = (object) [
                    "id_customer" => $customer['id_customer'],
                    "id_adress" => $shipping_address["id_shipping_address"],
                    "named" => $shipping_address["address_name"],
                    "firstname" => $shipping_address["customer_address"]["first_name"],
                    "lastname" => $shipping_address["customer_address"]["last_name"],
                    "street" => $shipping_address["customer_address"]["address"],
                    "complement_adress" => $shipping_address["customer_address"]["complement_address"],
                    "postcode" => $shipping_address["customer_address"]["postal_code"],
                    "city" => $shipping_address["customer_address"]["city"],
                    "country" => $shipping_address["customer_address"]["country"]["name"],
                    "country_obj"=> (object) [
                        "id" => $shipping_address["customer_address"]["country"]["id_customer_country"],
                        "name" => $shipping_address["customer_address"]["country"]["name"],
                        "isocode" => $shipping_address["customer_address"]["country"]["isocode"]
                    ],
                    "phone"=> $shipping_address["customer_address"]["phone"],
                    "fax"=> $shipping_address["customer_address"]["fax"],
                    "iso_code" => $shipping_address["customer_address"]["country"]["isocode"],
                    "default" => $shipping_address["is_default"] ? 1 : 0,
                    /*"difficult_access"=> (object) [
                        "value" => $shipping_address["has_difficult_access"],
                        "display" => $shipping_address["has_difficult_access"] ? "true" : "false"
                    ],*/
                    "lng" => $shipping_address["customer_address"]["longitude"],
                    "lat" => $shipping_address["customer_address"]["latitude"],
                    "place_id"=> $shipping_address["customer_address"]["place_id"]
                ];
            }
            
            $data["address_shipping"] = $address_shipping;
        }

        if(isset($customer['invoice_address'])) {
            $data["address_billing"] = (object) [
                "firstname" => $customer['invoice_address']["customer_address"]["first_name"],
                "lastname" => $customer['invoice_address']["customer_address"]["last_name"],
                "street" => $customer['invoice_address']["customer_address"]["address"],
                "postcode" => $customer['invoice_address']["customer_address"]["postal_code"],
                "city" => $customer['invoice_address']["customer_address"]["city"],
                "country" => $customer['invoice_address']["customer_address"]["country"]["name"],
                "phone" => $customer['invoice_address']["customer_address"]["phone"],
                "fax" => $customer['invoice_address']["customer_address"]["fax"],
                "email" => $customer['invoice_address']["email"],
                "iso_code" => $customer['invoice_address']["customer_address"]["country"]["isocode"],
                "ccn3" => $customer['invoice_address']["customer_address"]["country"]["ccn3"],
                "dial_code" => $customer['invoice_address']["customer_address"]["country"]["phone_code"],
                "lng" => $customer['invoice_address']["customer_address"]["longitude"],
                "lat" => $customer['invoice_address']["customer_address"]["latitude"],
                "place_id" => $customer['invoice_address']["customer_address"]["place_id"]
            ];
        }
        
        return (object)$data;
    }
}