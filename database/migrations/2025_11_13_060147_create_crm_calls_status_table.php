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
        Schema::create('crm_calls_statuses', function (Blueprint $table) {
            $table->id('id_crm_calls_status'); // clé primaire non auto-incrémentée
            $table->string('name', 255);
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_calls_statuses');
    }
};
