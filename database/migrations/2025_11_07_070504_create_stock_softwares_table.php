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
        Schema::create('stock_softwares', function (Blueprint $table) {
            $table->unsignedBigInteger('id_stock_software')->primary();   // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 30);         // VARCHAR(30) NOT NULL
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_softwares');
    }
};
