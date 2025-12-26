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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('id_profile');    // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50);          // VARCHAR(50) NOT NULL
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('profiles')->insert([
            ['id_profile' => 1, 'name' => 'Newsletter'],
            ['id_profile' => 2, 'name' => 'Commandes'],
            ['id_profile' => 3, 'name' => 'Comptabilité'],
            ['id_profile' => 4, 'name' => 'Démarchage'],
            ['id_profile' => 5, 'name' => 'Logistique'],
            ['id_profile' => 6, 'name' => 'Cabinet comptable externe'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};