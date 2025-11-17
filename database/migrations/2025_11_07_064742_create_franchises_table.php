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
        Schema::create('franchises', function (Blueprint $table) {
            $table->unsignedBigInteger('id_franchise')->primary();   // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 30);         // VARCHAR(30) NOT NULL
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
