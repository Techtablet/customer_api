<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id('id_shipping_address');
            $table->foreign('id_customer_address')->references('id_customer_address')->on('customer_addresses')->onDelete('restrict');
            $table->unsignedBigInteger('id_customer_address');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->boolean('is_default')->nullable()->unique(); // UNIQUE boolean flag
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
