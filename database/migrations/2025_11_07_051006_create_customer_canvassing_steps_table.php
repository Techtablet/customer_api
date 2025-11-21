<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_canvassing_steps', function (Blueprint $table) {
            $table->id('id_customer_canvassing_step');
            $table->string('name', 200);
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_canvassing_steps');
    }
};
