<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_contact_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id_contact_profile')->primary(); // PRIMARY KEY
            $table->unsignedBigInteger('id_profile');
            $table->foreign('id_profile')->references('id_profile')->on('profiles')->onDelete('restrict');
            $table->unsignedBigInteger('id_contact');
            $table->foreign('id_contact')->references('id_customer_contact')->on('customer_contacts')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_contact_profiles');
    }
};
