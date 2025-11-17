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
        Schema::create('customer_refusal_reasons', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_refusal_reason')->primary();     // INT(11) NOT NULL PRIMARY KEY
            $table->text('description');          // TEXT NOT NULL
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_refusal_reasons');
    }
};
