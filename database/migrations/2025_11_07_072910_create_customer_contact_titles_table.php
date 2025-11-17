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
        Schema::create('customer_contact_titles', function (Blueprint $table) {
            $table->id('id_customer_contact_title');      // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50);            // VARCHAR(50) NOT NULL
            $table->timestamps();
        });

        // Insertion des valeurs initiales
        DB::table('customer_contact_titles')->insert([
            ['name' => 'Non défini', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mr', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mme', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mlle', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contact_titles');
    }
};
