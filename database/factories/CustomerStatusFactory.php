<?php

namespace Database\Factories;

use App\Models\CustomerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerStatus>
 */
class CustomerStatusFactory extends Factory
{
    protected $model = CustomerStatus::class;

    public function definition(): array
    {
        $statuses = [
            'Actif',
            'Inactif',
            'En attente',
            'Prospect',
            'Client',
            'Suspendu',
            'Archivé',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($statuses) . ' ' . $this->faker->numberBetween(1, 1000),
        ];
    }
}
