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
        Schema::create('customer_refusal_reasons', function (Blueprint $table) {
            $table->id('id_customer_refusal_reason');     // INT(11) NOT NULL PRIMARY KEY
            $table->text('description');          // TEXT NOT NULL
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('customer_refusal_reasons')->insert([
            ['id_customer_refusal_reason' => 1, 'description' => 'Trop Cher'],
            ['id_customer_refusal_reason' => 2, 'description' => 'J\'ai déjà des fournisseurs'],
            ['id_customer_refusal_reason' => 3, 'description' => 'Vous n\'êtes pas référencé sur mon logiciel/ ma franchise'],
            ['id_customer_refusal_reason' => 4, 'description' => 'Pas le temps de changer'],
            ['id_customer_refusal_reason' => 5, 'description' => 'Je n\'arrive pas à contacter le décisionnaire'],
            ['id_customer_refusal_reason' => 6, 'description' => 'Il me dit oui, mais il ne passe jamais de commande'],
            ['id_customer_refusal_reason' => 7, 'description' => 'Je passe des commandes chez vous mais avec un autre compte magasin'],
            ['id_customer_refusal_reason' => 8, 'description' => 'Je ne fais pas d\'accessoires de téléphone'],
            ['id_customer_refusal_reason' => 9, 'description' => 'J\'ai un encours de 10000€ auprès de mes autres fournisseurs'],
            ['id_customer_refusal_reason' => 10, 'description' => 'Le fournisseur est un ami et il ne peut pas le remplacer'],
            ['id_customer_refusal_reason' => 11, 'description' => 'Les achats sont fait par la centrale d\'achat'],
            ['id_customer_refusal_reason' => 12, 'description' => 'Autres'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_refusal_reasons');
    }
};