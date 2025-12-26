<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('stock_softwares', function (Blueprint $table) {
            $table->id('id_stock_software');   // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 30);         // VARCHAR(30) NOT NULL
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('stock_softwares')->insert([
            ['id_stock_software' => 1, 'name' => 'Win GSM'],
            ['id_stock_software' => 2, 'name' => 'Mobile Manager'],
            ['id_stock_software' => 3, 'name' => 'EBP'],
            ['id_stock_software' => 4, 'name' => '3G WIN'],
            ['id_stock_software' => 5, 'name' => 'Autres'],
            ['id_stock_software' => 6, 'name' => 'Trépidai'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_softwares');
    }
};