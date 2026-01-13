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
            $table->boolean('is_default')->default(false); // UNIQUE boolean flag
            // Métadonnées
            $table->string('address_name', 100)->comment('Nom personnalisé de l\'adresse');
            $table->boolean('has_difficult_access')->default(false)->comment('Accès difficile');
            
            $table->timestamps();

            // Index
            $table->index('has_difficult_access');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
