<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->id('id_customer_contact'); // PRIMARY KEY
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('phone_number', 16);            
            $table->string('email_address', 80);
            //title => civilité
            $table->unsignedBigInteger('id_contact_title');
            $table->foreign('id_contact_title')->references('id_customer_contact_title')->on('customer_contact_titles')->onDelete('restrict');
            $table->string('phone_number_2', 16)->nullable();
            //default
            $table->boolean('is_default')->default(false); // TINYINT(1)
            //$table->integer('role'); // INT(2)
            $table->integer('id_contact_role');
            $table->foreign('id_contact_role')->references('id_contact_role')->on('customer_contact_roles')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_contacts');
    }
};
