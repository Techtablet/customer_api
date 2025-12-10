<?php

namespace App\Http\Requests\CustomerScheduleRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreCustomerScheduleRequest",
 *     required={"id_customer", "day", "opening_time", "closure_time"},
 *     @OA\Property(
 *         property="id_customer",
 *         type="integer",
 *         description="ID du client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="day",
 *         type="array",
 *         description="Jours d'ouverture",
 *         @OA\Items(
 *             type="string",
 *             example="1"
 *         ),
 *         example={"1", "2", "3", "4", "5"}
 *     ),
 *     @OA\Property(
 *         property="opening_time",
 *         type="string",
 *         format="time",
 *         description="Heure d'ouverture",
 *         example="08:00"
 *     ),
 *     @OA\Property(
 *         property="closure_time",
 *         type="string",
 *         format="time",
 *         description="Heure de fermeture",
 *         example="18:00"
 *     ),
 *     @OA\Property(
 *         property="has_break",
 *         type="boolean",
 *         description="Indique si il y a une pause",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="break_time_begin",
 *         type="string",
 *         format="time",
 *         description="Heure de début de pause",
 *         nullable=true,
 *         example="12:00"
 *     ),
 *     @OA\Property(
 *         property="break_time_end",
 *         type="string",
 *         format="time",
 *         description="Heure de fin de pause",
 *         nullable=true,
 *         example="14:00"
 *     )
 * )
 */
class StoreCustomerScheduleRequest extends FormRequest
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
            'id_customer' => 'required|integer|exists:customers,id_customer',
            'day' => 'required|array|min:1',
            'day.*' => 'string|in:1,2,3,4,5,6,7',
            'opening_time' => 'required|date_format:H:i',
            'closure_time' => 'required|date_format:H:i|after:opening_time',
            'has_break' => 'sometimes|boolean',
            'break_time_begin' => [
                'nullable',
                'required_if:has_break,true',
                'date_format:H:i',
                'after_or_equal:opening_time',
                'before:break_time_end',
            ],
            'break_time_end' => [
                'nullable',
                'required_if:has_break,true',
                'date_format:H:i',
                'after:break_time_begin',
                'before_or_equal:closure_time',
            ],
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
            'id_customer.required' => 'L\'ID du client est obligatoire.',
            'id_customer.exists' => 'Le client spécifié n\'existe pas.',
            'day.required' => 'Les jours d\'ouverture sont obligatoires.',
            'day.array' => 'Les jours doivent être un tableau.',
            'day.min' => 'Au moins un jour doit être spécifié.',
            'day.*.in' => 'Les jours doivent être compris entre 1 (lundi) et 7 (dimanche).',
            'opening_time.required' => 'L\'heure d\'ouverture est obligatoire.',
            'opening_time.date_format' => 'L\'heure d\'ouverture doit être au format HH:MM.',
            'closure_time.required' => 'L\'heure de fermeture est obligatoire.',
            'closure_time.date_format' => 'L\'heure de fermeture doit être au format HH:MM.',
            'closure_time.after' => 'L\'heure de fermeture doit être après l\'heure d\'ouverture.',
            'break_time_begin.required_if' => 'L\'heure de début de pause est requise lorsque has_break est true.',
            'break_time_begin.date_format' => 'L\'heure de début de pause doit être au format HH:MM.',
            'break_time_begin.after_or_equal' => 'L\'heure de début de pause doit être égale ou après l\'heure d\'ouverture.',
            'break_time_begin.before' => 'L\'heure de début de pause doit être avant l\'heure de fin de pause.',
            'break_time_end.required_if' => 'L\'heure de fin de pause est requise lorsque has_break est true.',
            'break_time_end.date_format' => 'L\'heure de fin de pause doit être au format HH:MM.',
            'break_time_end.after' => 'L\'heure de fin de pause doit être après l\'heure de début de pause.',
            'break_time_end.before_or_equal' => 'L\'heure de fin de pause doit être égale ou avant l\'heure de fermeture.',
        ];
    }

    /**
     * Préparer les données pour validation.
     */
    protected function prepareForValidation()
    {
        // S'assurer que les jours sont un tableau
        if ($this->has('day') && is_string($this->day)) {
            $this->merge([
                'day' => json_decode($this->day, true) ?? [$this->day],
            ]);
        }

        // Ajouter les secondes aux heures si elles ne sont pas présentes
        $this->merge([
            'opening_time' => $this->formatTime($this->opening_time),
            'closure_time' => $this->formatTime($this->closure_time),
            'break_time_begin' => $this->break_time_begin ? $this->formatTime($this->break_time_begin) : null,
            'break_time_end' => $this->break_time_end ? $this->formatTime($this->break_time_end) : null,
        ]);
    }

    /**
     * Formater l'heure avec les secondes.
     *
     * @param string $time
     * @return string
     */
    private function formatTime($time)
    {
        if (empty($time)) {
            return $time;
        }

        // Si l'heure n'a pas de secondes, ajouter :00
        if (strlen($time) === 5 && strpos($time, ':') !== false) {
            return $time . ':00';
        }

        return $time;
    }
}