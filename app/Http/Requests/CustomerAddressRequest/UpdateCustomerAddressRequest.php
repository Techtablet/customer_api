<?php

namespace App\Http\Requests\CustomerAddressRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerAddressRequest",
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         maxLength=64,
 *         description="Prénom",
 *         example="Jean"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         maxLength=64,
 *         description="Nom",
 *         example="Dupont"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         maxLength=255,
 *         description="Adresse",
 *         example="123 Rue de la République"
 *     ),
 *     @OA\Property(
 *         property="complement_address",
 *         type="string",
 *         maxLength=200,
 *         nullable=true,
 *         description="Complément d'adresse",
 *         example="Bâtiment A, étage 2"
 *     ),
 *     @OA\Property(
 *         property="postal_code",
 *         type="string",
 *         maxLength=10,
 *         description="Code postal",
 *         example="75001"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         maxLength=64,
 *         description="Ville",
 *         example="Paris"
 *     ),
 *     @OA\Property(
 *         property="id_country",
 *         type="integer",
 *         description="ID du pays",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=20,
 *         description="Téléphone",
 *         example="+33123456789"
 *     ),
 *     @OA\Property(
 *         property="fax",
 *         type="string",
 *         maxLength=20,
 *         nullable=true,
 *         description="Fax",
 *         example="+33123456780"
 *     ),
 *     @OA\Property(
 *         property="longitude",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Longitude",
 *         example=2.3522219
 *     ),
 *     @OA\Property(
 *         property="latitude",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         description="Latitude",
 *         example=48.856614
 *     ),
 *     @OA\Property(
 *         property="place_id",
 *         type="string",
 *         maxLength=150,
 *         nullable=true,
 *         description="ID de lieu Google Maps",
 *         example="ChIJD7fiBh9u5kcRYJSMaMOCCwQ"
 *     )
 * )
 */
class UpdateCustomerAddressRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:64',
            'last_name' => 'nullable|string|max:64',
            'address' => 'sometimes|string|max:255',
            'complement_address' => 'nullable|string|max:200',
            'postal_code' => 'sometimes|string|max:100',
            'city' => 'sometimes|string|max:64',
            'id_country' => 'sometimes|integer|exists:customer_countries,id_customer_country',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'longitude' => 'nullable|numeric|between:-180,180',
            'latitude' => 'nullable|numeric|between:-90,90',
            'place_id' => 'nullable|string|max:150',
        ];
    }

    /**
     * Obtenir les messages d'erreur personnalisés pour les règles de validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.max' => 'Le prénom ne peut pas dépasser :max caractères.',
            'last_name.string' => 'Le nom doit être une chaîne de caractères.',
            'last_name.max' => 'Le nom ne peut pas dépasser :max caractères.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne peut pas dépasser :max caractères.',
            'complement_address.string' => 'Le complément d\'adresse doit être une chaîne de caractères.',
            'complement_address.max' => 'Le complément d\'adresse ne peut pas dépasser :max caractères.',
            'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max' => 'Le code postal ne peut pas dépasser :max caractères.',
            'city.string' => 'La ville doit être une chaîne de caractères.',
            'city.max' => 'La ville ne peut pas dépasser :max caractères.',
            'id_country.integer' => 'Le pays doit être un identifiant valide.',
            'id_country.exists' => 'Le pays sélectionné n\'existe pas.',
            'phone.string' => 'Le téléphone doit être une chaîne de caractères.',
            'phone.max' => 'Le téléphone ne peut pas dépasser :max caractères.',
            'fax.string' => 'Le fax doit être une chaîne de caractères.',
            'fax.max' => 'Le fax ne peut pas dépasser :max caractères.',
            'longitude.numeric' => 'La longitude doit être un nombre.',
            'longitude.between' => 'La longitude doit être comprise entre -180 et 180.',
            'latitude.numeric' => 'La latitude doit être un nombre.',
            'latitude.between' => 'La latitude doit être comprise entre -90 et 90.',
            'place_id.string' => 'L\'ID de lieu doit être une chaîne de caractères.',
            'place_id.max' => 'L\'ID de lieu ne peut pas dépasser :max caractères.',
        ];
    }
}