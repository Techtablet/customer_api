<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_schedules', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->text('day')->comment('exemple de valeur ["1", "2", "3", "4", "5", "6", "7"]');
            $table->time('opening_time');
            $table->time('closure_time');
            $table->boolean('has_break')->default(false);
            $table->time('break_time_begin')->nullable();
            $table->time('break_time_end')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_schedules');
    }
};
