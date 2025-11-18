<?php

namespace App\Http\Requests\CustomerStatusRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Interdit de modifier l’ID lors du update
            'id_customer_status' => ['prohibited'],

            'name'  => ['sometimes', 'string', 'max:60'],
            'color' => ['sometimes', 'string', 'max:15'],
        ];
    }
}
