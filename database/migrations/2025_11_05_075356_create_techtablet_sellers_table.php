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
        Schema::create('techtablet_sellers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_techtablet_seller')->primary(); // clé primaire
            $table->string('first_name', 30);
            $table->string('last_name', 200)->nullable()->default(null);
            $table->string('phone1', 70)->nullable()->default(null);
            $table->string('phone2', 70)->nullable()->default(null);
            $table->string('post', 100)->nullable()->default(null);
            $table->string('key', 30);
            $table->longText('sign');
            $table->string('email', 80);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techtablet_sellers');
    }
};
