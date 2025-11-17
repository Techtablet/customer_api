<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('id_schedule')->primary();
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->text('day');
            $table->time('opening_time');
            $table->time('closure_time');
            $table->boolean('has_break');
            $table->time('break_time_begin');
            $table->time('break_time_end');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_schedules');
    }
};
