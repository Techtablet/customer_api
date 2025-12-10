<?php

namespace App\Http\Requests\CustomerStatRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateCustomerStatRequest",
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="arevage_ordervalue",
 *         type="number",
 *         format="float",
 *         description="Valeur moyenne des commandes",
 *         example=1500.75
 *     ),
 *     @OA\Property(
 *         property="last_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Dernière commande",
 *         example="2024-12-15"
 *     ),
 *     @OA\Property(
 *         property="first_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Première commande",
 *         example="2024-01-15"
 *     ),
 *     @OA\Property(
 *         property="profitability",
 *         type="number",
 *         format="float",
 *         description="Rentabilité totale",
 *         example=5000.25
 *     ),
 *     @OA\Property(
 *         property="profitabilityOneYear",
 *         type="number",
 *         format="float",
 *         description="Rentabilité sur un an",
 *         example=3000.50
 *     ),
 *     @OA\Property(
 *         property="profitabilityThreeMonth",
 *         type="number",
 *         format="float",
 *         description="Rentabilité sur trois mois",
 *         example=1000.75
 *     ),
 *     @OA\Property(
 *         property="turnover",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires total",
 *         example=25000.00
 *     ),
 *     @OA\Property(
 *         property="turnoverOneYear",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires sur un an",
 *         example=15000.00
 *     ),
 *     @OA\Property(
 *         property="turnoverThreeMonth",
 *         type="number",
 *         format="float",
 *         description="Chiffre d'affaires sur trois mois",
 *         example=5000.00
 *     ),
 *     @OA\Property(
 *         property="point1",
 *         type="number",
 *         format="float",
 *         description="Point 1",
 *         example=85.5
 *     ),
 *     @OA\Property(
 *         property="point2",
 *         type="number",
 *         format="float",
 *         description="Point 2",
 *         example=90.0
 *     ),
 *     @OA\Property(
 *         property="point3",
 *         type="number",
 *         format="float",
 *         description="Point 3",
 *         example=75.25
 *     ),
 *     @OA\Property(
 *         property="point4",
 *         type="number",
 *         format="float",
 *         description="Point 4",
 *         example=80.0
 *     ),
 *     @OA\Property(
 *         property="point5",
 *         type="number",
 *         format="float",
 *         description="Point 5",
 *         example=95.5
 *     ),
 *     @OA\Property(
 *         property="point6",
 *         type="number",
 *         format="float",
 *         description="Point 6",
 *         example=88.75
 *     ),
 *     @OA\Property(
 *         property="point7",
 *         type="number",
 *         format="float",
 *         description="Point 7",
 *         example=92.0
 *     ),
 *     @OA\Property(
 *         property="point8",
 *         type="number",
 *         format="float",
 *         description="Point 8",
 *         example=70.5
 *     ),
 *     @OA\Property(
 *         property="point9",
 *         type="number",
 *         format="float",
 *         description="Point 9",
 *         example=85.0
 *     ),
 *     @OA\Property(
 *         property="point10",
 *         type="number",
 *         format="float",
 *         description="Point 10",
 *         example=78.25
 *     ),
 *     @OA\Property(
 *         property="point11",
 *         type="number",
 *         format="float",
 *         description="Point 11",
 *         example=82.5
 *     ),
 *     @OA\Property(
 *         property="point12",
 *         type="number",
 *         format="float",
 *         description="Point 12",
 *         example=91.0
 *     ),
 *     @OA\Property(
 *         property="point13",
 *         type="number",
 *         format="float",
 *         description="Point 13",
 *         example=87.75
 *     ),
 *     @OA\Property(
 *         property="profitability_lifepercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité totale",
 *         example=20.5
 *     ),
 *     @OA\Property(
 *         property="profitability_yearrpercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité annuelle",
 *         example=18.75
 *     ),
 *     @OA\Property(
 *         property="profitability_threepercent",
 *         type="number",
 *         format="float",
 *         description="Pourcentage de rentabilité trimestrielle",
 *         example=15.25
 *     ),
 *     @OA\Property(
 *         property="promise_of_order_added",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Date d'ajout de la promesse de commande",
 *         example="2024-12-01"
 *     ),
 *     @OA\Property(
 *         property="promise_of_order",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Date de promesse de commande",
 *         example="2024-12-31"
 *     )
 * )
 */
class UpdateCustomerStatRequest extends FormRequest
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
            'id_customer' => 'sometimes|integer|exists:customers,id_customer',
            'arevage_ordervalue' => 'nullable|numeric',
            'last_order' => 'nullable|date',
            'first_order' => 'nullable|date',
            'profitability' => 'nullable|numeric',
            'profitabilityOneYear' => 'nullable|numeric',
            'profitabilityThreeMonth' => 'nullable|numeric',
            'turnover' => 'nullable|numeric',
            'turnoverOneYear' => 'nullable|numeric',
            'turnoverThreeMonth' => 'nullable|numeric',
            'point1' => 'nullable|numeric',
            'point2' => 'nullable|numeric',
            'point3' => 'nullable|numeric',
            'point4' => 'nullable|numeric',
            'point5' => 'nullable|numeric',
            'point6' => 'nullable|numeric',
            'point7' => 'nullable|numeric',
            'point8' => 'nullable|numeric',
            'point9' => 'nullable|numeric',
            'point10' => 'nullable|numeric',
            'point11' => 'nullable|numeric',
            'point12' => 'nullable|numeric',
            'point13' => 'nullable|numeric',
            'profitability_lifepercent' => 'nullable|numeric|between:0,100',
            'profitability_yearrpercent' => 'nullable|numeric|between:0,100',
            'profitability_threepercent' => 'nullable|numeric|between:0,100',
            'promise_of_order_added' => 'nullable|date',
            'promise_of_order' => 'nullable|date',
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
            'id_customer.exists' => 'Le client sélectionné n\'existe pas.',
            'arevage_ordervalue.numeric' => 'La valeur moyenne des commandes doit être un nombre.',
            'last_order.date' => 'La date de dernière commande doit être une date valide.',
            'first_order.date' => 'La date de première commande doit être une date valide.',
            'profitability.numeric' => 'La rentabilité doit être un nombre.',
            'profitabilityOneYear.numeric' => 'La rentabilité sur un an doit être un nombre.',
            'profitabilityThreeMonth.numeric' => 'La rentabilité sur trois mois doit être un nombre.',
            'turnover.numeric' => 'Le chiffre d\'affaires doit être un nombre.',
            'turnoverOneYear.numeric' => 'Le chiffre d\'affaires sur un an doit être un nombre.',
            'turnoverThreeMonth.numeric' => 'Le chiffre d\'affaires sur trois mois doit être un nombre.',
            'point1.numeric' => 'Le point 1 doit être un nombre.',
            'point2.numeric' => 'Le point 2 doit être un nombre.',
            'point3.numeric' => 'Le point 3 doit être un nombre.',
            'point4.numeric' => 'Le point 4 doit être un nombre.',
            'point5.numeric' => 'Le point 5 doit être un nombre.',
            'point6.numeric' => 'Le point 6 doit être un nombre.',
            'point7.numeric' => 'Le point 7 doit être un nombre.',
            'point8.numeric' => 'Le point 8 doit être un nombre.',
            'point9.numeric' => 'Le point 9 doit être un nombre.',
            'point10.numeric' => 'Le point 10 doit être un nombre.',
            'point11.numeric' => 'Le point 11 doit être un nombre.',
            'point12.numeric' => 'Le point 12 doit être un nombre.',
            'point13.numeric' => 'Le point 13 doit être un nombre.',
            'profitability_lifepercent.numeric' => 'Le pourcentage de rentabilité totale doit être un nombre.',
            'profitability_lifepercent.between' => 'Le pourcentage de rentabilité totale doit être compris entre 0 et 100.',
            'profitability_yearrpercent.numeric' => 'Le pourcentage de rentabilité annuelle doit être un nombre.',
            'profitability_yearrpercent.between' => 'Le pourcentage de rentabilité annuelle doit être compris entre 0 et 100.',
            'profitability_threepercent.numeric' => 'Le pourcentage de rentabilité trimestrielle doit être un nombre.',
            'profitability_threepercent.between' => 'Le pourcentage de rentabilité trimestrielle doit être compris entre 0 et 100.',
            'promise_of_order_added.date' => 'La date d\'ajout de promesse de commande doit être une date valide.',
            'promise_of_order.date' => 'La date de promesse de commande doit être une date valide.',
        ];
    }
}