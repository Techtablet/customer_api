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
        Schema::create('store_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('id_store_group')->primary();          // INT(11) NOT NULL PRIMARY KEY
            $table->string('group_name', 200);              // VARCHAR(200) NOT NULL
            $table->string('group_key', 100);               // VARCHAR(100) NOT NULL
            $table->string('group_logo', 200)->nullable();  // VARCHAR(200) NULL DEFAULT NULL
            $table->string('name', 200);                    // VARCHAR(200) NOT NULL
            $table->string('lastname', 200);                // VARCHAR(200) NOT NULL
            $table->tinyInteger('is_sepa')->default(0);    // TINYINT(4) NOT NULL DEFAULT 0
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_groups');
    }
};
