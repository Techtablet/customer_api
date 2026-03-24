<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id('id_shipping_address');
            $table->foreign('id_customer_address')->references('id_customer_address')->on('customer_addresses')->onDelete('restrict');
            $table->unsignedBigInteger('id_customer_address');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->boolean('is_default')->default(false); // UNIQUE boolean flag
            // Métadonnées
            $table->string('address_name', 100)->comment('Nom personnalisé de l\'adresse');
            $table->boolean('has_difficult_access')->default(false)->comment('Accès difficile');
            
            $table->timestamps();

            // Index
            $table->index('has_difficult_access');

            
        });

        // Ajouter la colonne générée après la création de la table
        // car Laravel ne supporte pas nativement les colonnes générées
        DB::statement('
            ALTER TABLE shipping_addresses 
            ADD COLUMN default_flag VARCHAR(255) AS (
                CASE WHEN is_default = 1 THEN CONCAT(id_customer, \'_default\') ELSE NULL END
            ) STORED
        ');

        // Créer l'index unique sur la colonne générée
        DB::statement('
            CREATE UNIQUE INDEX unique_default_per_customer 
            ON shipping_addresses (default_flag)
        ');
    }

    public function down(): void
    {
        // Supprimer d'abord l'index unique
        DB::statement('DROP INDEX IF EXISTS unique_default_per_customer ON shipping_addresses');
        
        // Supprimer la colonne générée
        DB::statement('ALTER TABLE shipping_addresses DROP COLUMN IF EXISTS default_flag');
        
        // Supprimer la table
        Schema::dropIfExists('shipping_addresses');
    }
};
