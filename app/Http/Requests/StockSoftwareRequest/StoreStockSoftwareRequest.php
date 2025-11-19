<?php

namespace App\Http\Requests\StockSoftwareRequest;

use Illuminate\Foundation\Http\FormRequest;


class StoreStockSoftwareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30'
        ];
    }
}
