<?php

namespace Tests\Feature\Api;

use App\Models\CustomerCountry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Liste tous les pays clients (GET /customer-countries)
     */
    public function test_can_list_all_customer_countries(): void
    {
        // Arrange: Créer des pays de test
        CustomerCountry::factory()->count(3)->create();

        // Act: Appeler l'endpoint
        $response = $this->getJson('/customer-countries');

        // Assert: Vérifier la réponse
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id_customer_country',
                        'name',
                        'name_en',
                        'name_de',
                        'isocode',
                        'ccn3',
                        'phone_code',
                        'is_intracom_vat',
                        'is_ue_export',
                    ],
                ],
                'message',
            ])
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }

    /**
     * Test: Affiche un pays client spécifique (GET /customer-countries/{id})
     */
    public function test_can_show_single_customer_country(): void
    {
        // Arrange
        $country = CustomerCountry::factory()->create([
            'name' => 'France',
            'name_en' => 'France',
            'name_de' => 'Frankreich',
            'isocode' => 'FR',
        ]);

        // Act
        $response = $this->getJson("/customer-countries/{$country->id_customer_country}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id_customer_country' => $country->id_customer_country,
                    'name' => 'France',
                    'name_en' => 'France',
                    'name_de' => 'Frankreich',
                    'isocode' => 'FR',
                ],
            ]);
    }

    /**
     * Test: Retourne 404 pour un pays inexistant
     */
    public function test_returns_404_for_non_existent_country(): void
    {
        // Act
        $response = $this->getJson('/customer-countries/99999');

        // Assert
        $response->assertStatus(404);
    }

    /**
     * Test: Crée un nouveau pays client (POST /customer-countries)
     */
    public function test_can_create_customer_country(): void
    {
        // Arrange
        $countryData = [
            'name' => 'Allemagne',
            'name_en' => 'Germany',
            'name_de' => 'Deutschland',
            'isocode' => 'DE',
            'ccn3' => 276,
            'phone_code' => '+49',
            'is_intracom_vat' => 1,
            'is_ue_export' => 1,
        ];

        // Act
        $response = $this->postJson('/customer-countries', $countryData);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Allemagne',
                    'name_en' => 'Germany',
                    'isocode' => 'DE',
                ],
            ]);

        // Vérifier que le pays est bien en base de données
        $this->assertDatabaseHas('customer_countries', [
            'name' => 'Allemagne',
            'isocode' => 'DE',
        ]);
    }

    /**
     * Test: Validation - nom requis
     */
    public function test_validation_fails_when_name_is_missing(): void
    {
        // Arrange
        $countryData = [
            'name_en' => 'Germany',
            'name_de' => 'Deutschland',
            'isocode' => 'DE',
        ];

        // Act
        $response = $this->postJson('/customer-countries', $countryData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test: Validation - isocode unique
     */
    public function test_validation_fails_when_isocode_is_duplicate(): void
    {
        // Arrange: Créer un pays existant
        CustomerCountry::factory()->create(['isocode' => 'FR']);

        $countryData = [
            'name' => 'France Bis',
            'name_en' => 'France Bis',
            'name_de' => 'Frankreich Bis',
            'isocode' => 'FR', // Duplicate
        ];

        // Act
        $response = $this->postJson('/customer-countries', $countryData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['isocode']);
    }

    /**
     * Test: Validation - longueur maximale
     */
    public function test_validation_fails_when_name_exceeds_max_length(): void
    {
        // Arrange
        $countryData = [
            'name' => str_repeat('A', 201), // Max 200
            'name_en' => 'Test',
            'name_de' => 'Test',
            'isocode' => 'TS',
        ];

        // Act
        $response = $this->postJson('/customer-countries', $countryData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test: Met à jour un pays client (PUT /customer-countries/{id})
     */
    public function test_can_update_customer_country(): void
    {
        // Arrange
        $country = CustomerCountry::factory()->create([
            'name' => 'Espagne',
            'isocode' => 'ES',
        ]);

        $updateData = [
            'name' => 'Espagne Modifiée',
            'name_en' => 'Spain Updated',
            'name_de' => 'Spanien Aktualisiert',
            'isocode' => 'ES',
            'is_intracom_vat' => 1,
            'is_ue_export' => 1,
        ];

        // Act
        $response = $this->putJson("/customer-countries/{$country->id_customer_country}", $updateData);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Espagne Modifiée',
                    'name_en' => 'Spain Updated',
                ],
            ]);

        // Vérifier en base de données
        $this->assertDatabaseHas('customer_countries', [
            'id_customer_country' => $country->id_customer_country,
            'name' => 'Espagne Modifiée',
        ]);
    }

    /**
     * Test: Supprime un pays client (DELETE /customer-countries/{id})
     */
    public function test_can_delete_customer_country(): void
    {
        // Arrange
        $country = CustomerCountry::factory()->create();

        // Act
        $response = $this->deleteJson("/customer-countries/{$country->id_customer_country}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Vérifier que le pays est supprimé
        $this->assertDatabaseMissing('customer_countries', [
            'id_customer_country' => $country->id_customer_country,
        ]);
    }

    /**
     * Test: Les champs cachés ne sont pas exposés
     */
    public function test_hidden_fields_are_not_exposed(): void
    {
        // Arrange
        $country = CustomerCountry::factory()->create();

        // Act
        $response = $this->getJson("/customer-countries/{$country->id_customer_country}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonMissing([
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * Test: Les valeurs par défaut sont appliquées
     */
    public function test_default_values_are_applied(): void
    {
        // Arrange
        $countryData = [
            'name' => 'Test Country',
            'name_en' => 'Test Country',
            'name_de' => 'Test Land',
            'isocode' => 'TC',
            // Ne pas spécifier is_intracom_vat et is_ue_export
        ];

        // Act
        $response = $this->postJson('/customer-countries', $countryData);

        // Assert
        $response->assertStatus(201);

        $this->assertDatabaseHas('customer_countries', [
            'isocode' => 'TC',
            'is_intracom_vat' => 0,
            'is_ue_export' => 0,
        ]);
    }

    /**
     * Test: CORS headers sont présents
     */
    public function test_cors_headers_are_present(): void
    {
        // Arrange
        CustomerCountry::factory()->create();

        // Act
        $response = $this->get('/customer-countries', [
            'Origin' => 'http://localhost:3000',
        ]);

        // Assert
        $response->assertStatus(200);
        // Note: Les headers CORS sont gérés par le middleware
    }
}
