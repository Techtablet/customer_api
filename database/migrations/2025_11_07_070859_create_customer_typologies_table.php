<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('customer_typologies', function (Blueprint $table) {
            $table->id('id_customer_typologie');            // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50)->default('');     // VARCHAR(50) NOT NULL DEFAULT ''
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('customer_typologies')->insert([
            ['id_customer_typologie' => 1, 'name' => 'Magasin'],
            ['id_customer_typologie' => 2, 'name' => 'Mairie'],
            ['id_customer_typologie' => 3, 'name' => 'Reconditionneur'],
            ['id_customer_typologie' => 4, 'name' => 'Hypermarché'],
            ['id_customer_typologie' => 5, 'name' => 'Supermarché'],
            ['id_customer_typologie' => 6, 'name' => 'Intégrateur'],
            ['id_customer_typologie' => 7, 'name' => 'Autres'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_typologies');
    }
};