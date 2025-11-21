<?php

namespace Database\Factories;

use App\Models\CustomerCountry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerCountry>
 */
class CustomerCountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerCountry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countries = [
            ['name' => 'France', 'name_en' => 'France', 'name_de' => 'Frankreich', 'isocode' => 'FR', 'ccn3' => 250, 'phone_code' => '+33'],
            ['name' => 'Allemagne', 'name_en' => 'Germany', 'name_de' => 'Deutschland', 'isocode' => 'DE', 'ccn3' => 276, 'phone_code' => '+49'],
            ['name' => 'Espagne', 'name_en' => 'Spain', 'name_de' => 'Spanien', 'isocode' => 'ES', 'ccn3' => 724, 'phone_code' => '+34'],
            ['name' => 'Italie', 'name_en' => 'Italy', 'name_de' => 'Italien', 'isocode' => 'IT', 'ccn3' => 380, 'phone_code' => '+39'],
            ['name' => 'Belgique', 'name_en' => 'Belgium', 'name_de' => 'Belgien', 'isocode' => 'BE', 'ccn3' => 56, 'phone_code' => '+32'],
            ['name' => 'Pays-Bas', 'name_en' => 'Netherlands', 'name_de' => 'Niederlande', 'isocode' => 'NL', 'ccn3' => 528, 'phone_code' => '+31'],
            ['name' => 'Portugal', 'name_en' => 'Portugal', 'name_de' => 'Portugal', 'isocode' => 'PT', 'ccn3' => 620, 'phone_code' => '+351'],
            ['name' => 'Suisse', 'name_en' => 'Switzerland', 'name_de' => 'Schweiz', 'isocode' => 'CH', 'ccn3' => 756, 'phone_code' => '+41'],
        ];

        $country = $this->faker->randomElement($countries);

        return [
            'name' => $country['name'] . ' ' . $this->faker->unique()->numberBetween(1, 10000),
            'name_en' => $country['name_en'],
            'name_de' => $country['name_de'],
            'isocode' => $country['isocode'] . $this->faker->unique()->numberBetween(1, 999),
            'ccn3' => $country['ccn3'] ?? $this->faker->numberBetween(1, 999),
            'phone_code' => $country['phone_code'],
            'is_intracom_vat' => $this->faker->boolean(70), // 70% chance d'être UE
            'is_ue_export' => $this->faker->boolean(70),
        ];
    }

    /**
     * Indicate that the country is in the European Union.
     */
    public function europeanUnion(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_intracom_vat' => 1,
            'is_ue_export' => 1,
        ]);
    }

    /**
     * Indicate that the country is outside the European Union.
     */
    public function nonEuropeanUnion(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_intracom_vat' => 0,
            'is_ue_export' => 0,
        ]);
    }

    /**
     * Create France specifically.
     */
    public function france(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'France',
            'name_en' => 'France',
            'name_de' => 'Frankreich',
            'isocode' => 'FR',
            'ccn3' => 250,
            'phone_code' => '+33',
            'is_intracom_vat' => 1,
            'is_ue_export' => 1,
        ]);
    }
}
