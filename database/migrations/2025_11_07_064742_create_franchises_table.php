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
        Schema::create('franchises', function (Blueprint $table) {
            $table->id('id_franchise');   // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 30);         // VARCHAR(30) NOT NULL
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('franchises')->insert([
            ['id_franchise' => 1, 'name' => 'Telephone Store'],
            ['id_franchise' => 2, 'name' => 'Vivre Mobile'],
            ['id_franchise' => 3, 'name' => 'Avelis Connect'],
            ['id_franchise' => 4, 'name' => 'Indépendant'],
            ['id_franchise' => 5, 'name' => 'Coriolis Telecom'],
            ['id_franchise' => 6, 'name' => 'Allo PSM'],
            ['id_franchise' => 7, 'name' => 'Restore Phone'],
            ['id_franchise' => 8, 'name' => 'Easy Cash'],
            ['id_franchise' => 9, 'name' => 'SFR'],
            ['id_franchise' => 10, 'name' => 'Wizzle'],
            ['id_franchise' => 11, 'name' => 'Leclerc'],
            ['id_franchise' => 12, 'name' => 'Intégrateurs'],
            ['id_franchise' => 13, 'name' => 'Cash converters'],
            ['id_franchise' => 14, 'name' => 'Docteur I.T.'],
            ['id_franchise' => 15, 'name' => 'SAVE France'],
            ['id_franchise' => 16, 'name' => 'Docteur ordinateur'],
            ['id_franchise' => 17, 'name' => 'Bureau Vallée'],
            ['id_franchise' => 18, 'name' => 'Autres'],
            ['id_franchise' => 19, 'name' => 'Mairie/Administration'],
            ['id_franchise' => 20, 'name' => 'Auchan'],
            ['id_franchise' => 21, 'name' => 'LDLC'],
            ['id_franchise' => 22, 'name' => 'Happy Cash'],
            ['id_franchise' => 23, 'name' => 'MediaClinic'],
            ['id_franchise' => 24, 'name' => 'Happy Cash Services'],
            ['id_franchise' => 25, 'name' => 'Troc.com'],
            ['id_franchise' => 26, 'name' => 'La Trocante'],
            ['id_franchise' => 28, 'name' => 'iRiparo'],
            ['id_franchise' => 29, 'name' => '1001 Piles Batteries'],
            ['id_franchise' => 30, 'name' => 'Fnac-Darty'],
            ['id_franchise' => 31, 'name' => 'Carrefour'],
            ['id_franchise' => 32, 'name' => 'Cock\'tel Store'],
            ['id_franchise' => 33, 'name' => 'Cash Express'],
            ['id_franchise' => 34, 'name' => 'Chrono Mobile'],
            ['id_franchise' => 35, 'name' => 'Intermarché'],
            ['id_franchise' => 36, 'name' => 'Happy Troc'],
            ['id_franchise' => 37, 'name' => 'Bouygues Telecom'],
            ['id_franchise' => 38, 'name' => 'Mobileo'],
            ['id_franchise' => 40, 'name' => 'International'],
            ['id_franchise' => 41, 'name' => 'Compte demo'],
            ['id_franchise' => 42, 'name' => 'Allemagne'],
            ['id_franchise' => 43, 'name' => 'SAVE Espagne'],
            ['id_franchise' => 44, 'name' => 'Belgique'],
            ['id_franchise' => 45, 'name' => 'M Mobile'],
            ['id_franchise' => 46, 'name' => 'SAVE intégrés'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};