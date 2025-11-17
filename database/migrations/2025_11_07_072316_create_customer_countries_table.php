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
        Schema::create('customer_countries', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_country')->primary();             // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 200);                          // VARCHAR(200) NOT NULL
            $table->string('name_en', 70);                        // VARCHAR(70) NOT NULL
            $table->string('name_de', 70);                        // VARCHAR(70) NOT NULL
            $table->string('isocode', 5);                         // VARCHAR(5) NOT NULL
            $table->integer('ccn3')->nullable()->default(null);   // INT(11) NULL DEFAULT NULL
            $table->string('phone_code', 10)->nullable()->default(null); // VARCHAR(10) NULL DEFAULT NULL
            $table->tinyInteger('is_intracom_vat')->default(0);   // TINYINT(4) NOT NULL DEFAULT 0
            $table->tinyInteger('is_ue_export')->default(0);   // TINYINT(4) NOT NULL DEFAULT 0
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_countries');
    }
};
