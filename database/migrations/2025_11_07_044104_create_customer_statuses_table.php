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
        Schema::create('customer_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_status')->primary(); // correspond à INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 60);       // VARCHAR(60) NOT NULL
            $table->string('color', 15);      // VARCHAR(15) NOT NULL
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_statuses');
    }
};
