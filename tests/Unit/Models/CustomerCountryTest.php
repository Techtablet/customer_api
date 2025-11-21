<?php

namespace Tests\Unit\Models;

use App\Models\CustomerCountry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Le modèle utilise la bonne table
     */
    public function test_uses_correct_table(): void
    {
        $country = new CustomerCountry();
        
        $this->assertEquals('customer_countries', $country->getTable());
    }

    /**
     * Test: Le modèle utilise la bonne clé primaire
     */
    public function test_uses_correct_primary_key(): void
    {
        $country = new CustomerCountry();
        
        $this->assertEquals('id_customer_country', $country->getKeyName());
    }

    /**
     * Test: Les attributs fillable sont correctement définis
     */
    public function test_has_correct_fillable_attributes(): void
    {
        $country = new CustomerCountry();
        
        $expectedFillable = [
            'name',
            'name_en',
            'name_de',
            'isocode',
            'ccn3',
            'phone_code',
            'is_intracom_vat',
            'is_ue_export',
        ];
        
        $this->assertEquals($expectedFillable, $country->getFillable());
    }

    /**
     * Test: Les attributs hidden sont correctement définis
     */
    public function test_has_correct_hidden_attributes(): void
    {
        $country = new CustomerCountry();
        
        $expectedHidden = [
            'created_at',
            'updated_at',
        ];
        
        $this->assertEquals($expectedHidden, $country->getHidden());
    }

    /**
     * Test: Les casts sont correctement définis
     */
    public function test_has_correct_casts(): void
    {
        $country = new CustomerCountry();
        
        $this->assertEquals('integer', $country->getCasts()['is_intracom_vat']);
        $this->assertEquals('integer', $country->getCasts()['is_ue_export']);
        $this->assertEquals('integer', $country->getCasts()['ccn3']);
    }

    /**
     * Test: Les valeurs par défaut sont appliquées
     */
    public function test_applies_default_values(): void
    {
        $country = new CustomerCountry();
        
        $this->assertEquals(0, $country->is_intracom_vat);
        $this->assertEquals(0, $country->is_ue_export);
    }

    /**
     * Test: Peut créer un pays avec des données valides
     */
    public function test_can_create_country_with_valid_data(): void
    {
        $country = CustomerCountry::create([
            'name' => 'France',
            'name_en' => 'France',
            'name_de' => 'Frankreich',
            'isocode' => 'FR',
            'ccn3' => 250,
            'phone_code' => '+33',
            'is_intracom_vat' => 1,
            'is_ue_export' => 1,
        ]);

        $this->assertInstanceOf(CustomerCountry::class, $country);
        $this->assertEquals('France', $country->name);
        $this->assertEquals('FR', $country->isocode);
        $this->assertEquals(1, $country->is_intracom_vat);
    }

    /**
     * Test: Les timestamps sont cachés dans la sérialisation
     */
    public function test_timestamps_are_hidden_in_serialization(): void
    {
        $country = CustomerCountry::factory()->create();
        
        $array = $country->toArray();
        
        $this->assertArrayNotHasKey('created_at', $array);
        $this->assertArrayNotHasKey('updated_at', $array);
    }

    /**
     * Test: Les types sont correctement castés
     */
    public function test_attributes_are_correctly_casted(): void
    {
        $country = CustomerCountry::factory()->create([
            'is_intracom_vat' => '1',
            'is_ue_export' => '0',
            'ccn3' => '250',
        ]);

        $this->assertIsInt($country->is_intracom_vat);
        $this->assertIsInt($country->is_ue_export);
        $this->assertIsInt($country->ccn3);
    }

    /**
     * Test: La factory fonctionne correctement
     */
    public function test_factory_creates_valid_country(): void
    {
        $country = CustomerCountry::factory()->create();

        $this->assertInstanceOf(CustomerCountry::class, $country);
        $this->assertNotNull($country->name);
        $this->assertNotNull($country->isocode);
        $this->assertDatabaseHas('customer_countries', [
            'id_customer_country' => $country->id_customer_country,
        ]);
    }

    /**
     * Test: La factory peut créer un pays UE
     */
    public function test_factory_can_create_european_union_country(): void
    {
        $country = CustomerCountry::factory()->europeanUnion()->create();

        $this->assertEquals(1, $country->is_intracom_vat);
        $this->assertEquals(1, $country->is_ue_export);
    }

    /**
     * Test: La factory peut créer un pays hors UE
     */
    public function test_factory_can_create_non_european_union_country(): void
    {
        $country = CustomerCountry::factory()->nonEuropeanUnion()->create();

        $this->assertEquals(0, $country->is_intracom_vat);
        $this->assertEquals(0, $country->is_ue_export);
    }
}
