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
            $table->unsignedBigInteger('id_customer_contact_title')->primary();      // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50);            // VARCHAR(50) NOT NULL
            $table->timestamps();
        });

        // Insertion des valeurs initiales
        DB::table('customer_contact_titles')->insert([
            ['id_customer_contact_title' => 0, 'name' => 'Non défini', 'created_at' => now(), 'updated_at' => now()],
            ['id_customer_contact_title' => 1, 'name' => 'Mr', 'created_at' => now(), 'updated_at' => now()],
            ['id_customer_contact_title' => 2, 'name' => 'Mme', 'created_at' => now(), 'updated_at' => now()],
            ['id_customer_contact_title' => 3, 'name' => 'Mlle', 'created_at' => now(), 'updated_at' => now()],
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
