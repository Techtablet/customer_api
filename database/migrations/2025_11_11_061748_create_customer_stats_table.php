<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_stats', function (Blueprint $table) {
            $table->id('id_customer_stat');
            $table->unsignedBigInteger('id_customer')->unique();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->float('arevage_ordervalue')->default(0);
            $table->date('last_order')->nullable();
            $table->date('first_order')->nullable();
            $table->float('profitability')->default(0);
            $table->float('profitabilityOneYear')->default(0);
            $table->float('profitabilityThreeMonth')->default(0);
            $table->float('turnover')->default(0);
            $table->float('turnoverOneYear')->default(0);
            $table->float('turnoverThreeMonth')->default(0);
            $table->float('point1')->default(0);
            $table->float('point2')->default(0);
            $table->float('point3')->default(0);
            $table->float('point4')->default(0);
            $table->float('point5')->default(0);
            $table->float('point6')->default(0);
            $table->float('point7')->default(0);
            $table->float('point8')->default(0);
            $table->float('point9')->default(0);
            $table->float('point10')->default(0);
            $table->float('point11')->default(0);
            $table->float('point12')->default(0);
            $table->float('point13')->default(0);
            $table->float('profitability_lifepercent')->default(0);
            $table->float('profitability_yearrpercent')->default(0);
            $table->float('profitability_threepercent')->default(0);
            $table->date('promise_of_order_added')->nullable();
            $table->date('promise_of_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_stats');
    }
};
