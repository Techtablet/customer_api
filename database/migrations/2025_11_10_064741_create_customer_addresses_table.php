<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id('id_customer_address');
            
            // Informations personnelles
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            
            // Adresse
            $table->string('address', 255);
            $table->string('complement_address', 200)->nullable();
            $table->string('postal_code', 10);
            $table->string('city', 64);
            $table->unsignedBigInteger('id_country');
            
            // Coordonnées
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            
            // Géolocalisation
            $table->decimal('longitude', 11, 7)->nullable();
            $table->decimal('latitude', 11, 7)->nullable();
            $table->string('place_id', 150)->nullable();
            
            // Métadonnées
            $table->string('address_name', 64)->nullable()->comment('Nom personnalisé de l\'adresse');
            $table->boolean('has_difficult_access')->default(false)->comment('Accès difficile');
            
            $table->timestamps();
            
            // Clé étrangère
            $table->foreign('id_country')
                  ->references('id_customer_country')
                  ->on('customer_countries')
                  ->onDelete('restrict');
            
            // Index
            $table->index('id_country');
            $table->index('postal_code');
            $table->index(['city', 'postal_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};