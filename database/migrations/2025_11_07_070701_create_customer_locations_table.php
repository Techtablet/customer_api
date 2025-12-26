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
        Schema::create('customer_locations', function (Blueprint $table) {
            $table->id('id_customer_location');              // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50)->default('');       // VARCHAR(50) NOT NULL DEFAULT ''
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('customer_locations')->insert([
            ['id_customer_location' => 1, 'name' => 'Centre ville'],
            ['id_customer_location' => 2, 'name' => 'Galerie Marchande E.Leclerc'],
            ['id_customer_location' => 3, 'name' => 'Galerie Marchande Auchan'],
            ['id_customer_location' => 4, 'name' => 'Galerie Marchande Carrefour'],
            ['id_customer_location' => 5, 'name' => 'Galerie Marchande Intermarché'],
            ['id_customer_location' => 6, 'name' => 'Z.A.C'],
            ['id_customer_location' => 7, 'name' => 'Sans intérêt'],
            ['id_customer_location' => 8, 'name' => 'Galerie Marchande Hyper U'],
            ['id_customer_location' => 9, 'name' => 'Galerie Marchande géant Casino'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_locations');
    }
};