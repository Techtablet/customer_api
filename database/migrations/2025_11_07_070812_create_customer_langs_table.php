<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('customer_langs', function (Blueprint $table) {
            $table->id('id_customer_lang');      // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 250)->unique();           // VARCHAR(250) NOT NULL
            $table->string('code_iso', 10)->unique();            // VARCHAR(10) NOT NULL
            $table->timestamps();
        });

        // Ajouter des valeurs initiales
        DB::table('customer_langs')->insert([
            ['id_customer_lang' => 1, 'name' => 'Français', 'code_iso' => 'fr', 'created_at' => now(), 'updated_at' => now()],
            ['id_customer_lang' => 2, 'name' => 'English', 'code_iso' => 'en', 'created_at' => now(), 'updated_at' => now()],
            ['id_customer_lang' => 3, 'name' => 'Deutsch', 'code_iso' => 'de', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_langs');
    }
};
