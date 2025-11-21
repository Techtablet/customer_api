<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Vous pouvez ajouter des configurations communes ici
    }

    /**
     * Helper pour créer des headers JSON standards
     */
    protected function jsonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Helper pour vérifier la structure de réponse API standard
     */
    protected function assertApiResponse($response, int $status = 200): void
    {
        $response->assertStatus($status);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);
    }
}
