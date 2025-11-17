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
        Schema::create('customer_typologies', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_typologie')->primary();            // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50)->default('');     // VARCHAR(50) NOT NULL DEFAULT ''
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_typologies');
    }
};
