<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('crm_calls', function (Blueprint $table) {
            $table->id('id_crm_call'); // clé primaire
            $table->unsignedBigInteger('id_customer')->index(); // index sur id_customer
            
            $table->unsignedBigInteger('id_techtablet_seller');
            $table->foreign('id_techtablet_seller')->references('id_techtablet_seller')->on('techtablet_sellers')->onDelete('restrict');
            //status
            $table->unsignedBigInteger('id_crm_calls_status')->default(1);
            $table->foreign('id_crm_calls_status')->references('id_crm_calls_status')->on('crm_calls_statuses')->onDelete('restrict');

            $table->text('comment');
            $table->dateTime('date');
            $table->integer('shipping_done')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_calls');
    }
};
