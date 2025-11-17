<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id('id_customer_address');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('complement_adress', 200)->nullable();
            $table->string('adress', 255);
            $table->string('pc', 64);
            $table->string('ville', 64);
            $table->unsignedBigInteger('id_country');
            $table->foreign('id_country')->references('id_customer_country')->on('customer_countries')->onDelete('restrict');
            $table->string('phone', 16);
            $table->string('fax', 20);
            $table->decimal('lng', 11, 7);
            $table->decimal('lat', 11, 7);
            $table->string('place_id', 150);
            $table->string('named', 64);
            $table->tinyInteger('difficult_access');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
