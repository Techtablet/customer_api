<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        // Insertion des données initiales
        DB::table('customer_canvassing_steps')->insert([
            [
                'id_customer_canvassing_step' => 1,
                'name' => 'Je n\'ai pas eu le temps de le contacter',
                'order' => 0,
                'created_at' => '2022-02-22 13:20:01',
                'updated_at' => '2022-02-22 13:20:29'
            ],
            [
                'id_customer_canvassing_step' => 2,
                'name' => 'Je n\'arrive pas à contacter le décisionnaire',
                'order' => 1,
                'created_at' => '2022-02-22 13:20:01',
                'updated_at' => '2022-02-22 13:20:29'
            ],
            [
                'id_customer_canvassing_step' => 3,
                'name' => 'Le démarchage et commande de ce mag sont fait sur un autre mag du groupe',
                'order' => 2,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 4,
                'name' => 'Premier contact',
                'order' => 3,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 5,
                'name' => 'Envoi des docs',
                'order' => 4,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 6,
                'name' => 'Mail de relance',
                'order' => 5,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 7,
                'name' => 'Envoi de la box',
                'order' => 6,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 8,
                'name' => 'Feedback sur les échantillons',
                'order' => 7,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 9,
                'name' => 'En cours de démarchage',
                'order' => 8,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 10,
                'name' => 'Implantation en cours',
                'order' => 9,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 11,
                'name' => 'Fait du dépannage chez nous',
                'order' => 10,
                'created_at' => '2022-02-22 13:20:50',
                'updated_at' => '2022-02-22 13:22:36'
            ],
            [
                'id_customer_canvassing_step' => 12,
                'name' => 'Client Régulier',
                'order' => 11,
                'created_at' => '2022-02-22 13:22:40',
                'updated_at' => '2022-02-22 13:22:59'
            ],
            [
                'id_customer_canvassing_step' => 13,
                'name' => 'Pas intéressé',
                'order' => 12,
                'created_at' => '2022-02-22 13:22:40',
                'updated_at' => '2022-02-22 13:22:59'
            ],
            [
                'id_customer_canvassing_step' => 14,
                'name' => 'Remodelage en cours (magasin Auchan)',
                'order' => 13,
                'created_at' => '2023-05-08 12:52:31',
                'updated_at' => '2023-05-08 12:52:36'
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_canvassing_steps');
    }
};