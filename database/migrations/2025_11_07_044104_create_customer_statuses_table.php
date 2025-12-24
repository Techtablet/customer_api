<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_statuses', function (Blueprint $table) {
            $table->integer('id_customer_status')->primary(); // INT au lieu de id()
            $table->string('name', 60);
            $table->string('color', 15);
            $table->timestamps();
        });

        // Insérer les données
        DB::table('customer_statuses')->insert([
            ['id_customer_status' => 0, 'name' => 'Not defined', 'color' => 'blanc'],
            ['id_customer_status' => 1, 'name' => 'Ouvert', 'color' => 'vert'],
            ['id_customer_status' => 4, 'name' => 'Magasin fermé', 'color' => 'bleu'],
            ['id_customer_status' => 5, 'name' => 'Prospect', 'color' => 'mauve'],
            ['id_customer_status' => 7, 'name' => 'Prospect froid', 'color' => ''],
            ['id_customer_status' => 8, 'name' => 'Prospect Chaud', 'color' => ''],
            ['id_customer_status' => 11, 'name' => 'Nouveau client', 'color' => ''],
            ['id_customer_status' => 12, 'name' => 'A arrêté de commander', 'color' => ''],
            ['id_customer_status' => 13, 'name' => 'Compte démo', 'color' => ''],
            ['id_customer_status' => 14, 'name' => 'Pas de potentiel', 'color' => ''],
            ['id_customer_status' => 15, 'name' => 'Injoignable / Difficile à prospecter', 'color' => ''],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_statuses');
    }
};