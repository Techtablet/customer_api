<?php

namespace App\Http\Requests\CustomerStatusRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Tu peux définir l'ID lors de l'import
            'id_customer_status' => ['nullable', 'integer'],

            'name'  => ['required', 'string', 'max:60'],
            'color' => ['required', 'string', 'max:15'],
        ];
    }
}
