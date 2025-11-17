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
        Schema::create('crm_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('id_crm_tag')->primary(); // clé primaire
            $table->text('description');
            $table->boolean('inactive')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_tags');
    }
};
