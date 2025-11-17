<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('crm_customers_tags_history', function (Blueprint $table) {
            $table->unsignedBigInteger('id_crm_tags_history')->primary(); // clé primaire non auto-incrémentée
            $table->unsignedBigInteger('id_crm_tag');
            $table->foreign('id_crm_tag')->references('id_crm_tag')->on('crm_tags')->onDelete('restrict');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_customers_tags_history');
    }
};
