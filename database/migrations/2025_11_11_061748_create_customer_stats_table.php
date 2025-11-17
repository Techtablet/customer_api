<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_stat')->primary();
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            $table->float('arevage_ordervalue');
            $table->date('last_order');
            $table->date('first_order');
            $table->float('profitability');
            $table->float('profitabilityOneYear');
            $table->float('profitabilityThreeMonth');
            $table->float('turnover');
            $table->float('turnoverOneYear');
            $table->float('turnoverThreeMonth');
            $table->float('point1');
            $table->float('point2');
            $table->float('point3');
            $table->float('point4');
            $table->float('point5');
            $table->float('point6');
            $table->float('point7');
            $table->float('point8');
            $table->float('point9');
            $table->float('point10');
            $table->float('point11');
            $table->float('point12');
            $table->float('point13');
            $table->float('profitability_lifepercent');
            $table->float('profitability_yearrpercent');
            $table->float('profitability_threepercent');
            $table->date('promise_of_order_added');
            $table->date('promise_of_order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_stats');
    }
};
