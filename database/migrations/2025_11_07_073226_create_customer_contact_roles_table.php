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
        Schema::create('customer_contact_roles', function (Blueprint $table) {
            $table->id('id_contact_role');    // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50);          // VARCHAR(50) NOT NULL
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contact_roles');
    }
};
