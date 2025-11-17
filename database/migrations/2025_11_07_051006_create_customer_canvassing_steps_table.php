<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_canvassing_steps', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_canvassing_step')->primary();
            $table->string('name', 200);
            $table->integer('ordre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_canvassing_steps');
    }
};
