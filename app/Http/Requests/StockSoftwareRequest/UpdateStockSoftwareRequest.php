<?php

namespace App\Http\Requests\StockSoftwareRequest;

use Illuminate\Foundation\Http\FormRequest;


class UpdateStockSoftwareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:30'
        ];
    }
}
