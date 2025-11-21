<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('techtablet_sellers', function (Blueprint $table) {
            $table->id('id_techtablet_seller');
            
            // Informations personnelles
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            
            // Coordonnées
            $table->string('primary_phone', 20)->nullable()->comment('Téléphone principal');
            $table->string('secondary_phone', 20)->nullable()->comment('Téléphone secondaire');
            $table->string('email', 150)->nullable()->comment('Email professionnel');
            
            // Informations professionnelles
            $table->string('job_title', 100)->nullable()->comment('Poste/emploi occupé');
            $table->string('employee_code', 30)->unique()->comment('Code employé unique');
            $table->text('digital_signature')->nullable()->comment('Signature numérique');
            
            // Statut
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index pour performances
            $table->index('employee_code');
            $table->index('email');
            $table->index('is_active');
            $table->index(['first_name', 'last_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('techtablet_sellers');
    }
};