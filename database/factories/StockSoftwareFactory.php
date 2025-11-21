<?php

namespace Database\Factories;

use App\Models\StockSoftware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockSoftware>
 */
class StockSoftwareFactory extends Factory
{
    protected $model = StockSoftware::class;

    public function definition(): array
    {
        $softwares = [
            'Wingsm',
            '3gwin',
            'Générique',
            'Trépidai',
            'SAP',
            'Oracle',
            'Custom ERP',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($softwares) . ' ' . $this->faker->numberBetween(1, 100),
        ];
    }
}
