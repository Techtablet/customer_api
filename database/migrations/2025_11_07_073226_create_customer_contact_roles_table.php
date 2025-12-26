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
        Schema::create('customer_contact_roles', function (Blueprint $table) {
            $table->integer('id_contact_role')->primary();    // INT(11) NOT NULL PRIMARY KEY
            $table->string('name', 50);          // VARCHAR(50) NOT NULL
            $table->timestamps();
        });

        // Insertion des données initiales
        DB::table('customer_contact_roles')->insert([
            ['id_contact_role' => 0, 'name' => 'Pas encore défini'],
            ['id_contact_role' => 1, 'name' => 'Animateur/Responsable des ventes'],
            ['id_contact_role' => 2, 'name' => 'Gérant de magasin'],
            ['id_contact_role' => 3, 'name' => 'Vendeur'],
            ['id_contact_role' => 4, 'name' => 'Responsable achat'],
            ['id_contact_role' => 5, 'name' => 'Comptable'],
            ['id_contact_role' => 6, 'name' => 'Technicien'],
            ['id_contact_role' => 7, 'name' => 'Propriétaire multi boutiques'],
            ['id_contact_role' => 8, 'name' => 'Responsable point de vente'],
            ['id_contact_role' => 9, 'name' => 'Assistant commercial'],
            ['id_contact_role' => 11, 'name' => 'Directeur de magasin'],
            ['id_contact_role' => 12, 'name' => 'Logistique'],
            ['id_contact_role' => 13, 'name' => 'Chargé marketing terminaux'],
            ['id_contact_role' => 14, 'name' => 'Président'],
            ['id_contact_role' => 15, 'name' => 'Directeur général'],
            ['id_contact_role' => 16, 'name' => 'Liquidateur'],
            ['id_contact_role' => 17, 'name' => 'responsable supply chain'],
            ['id_contact_role' => 18, 'name' => 'Directeur Commercial B to B'],
            ['id_contact_role' => 19, 'name' => 'ADV'],
            ['id_contact_role' => 20, 'name' => 'Responsable Réseau'],
            ['id_contact_role' => 21, 'name' => 'Acheteuse décisionnaire'],
            ['id_contact_role' => 22, 'name' => 'Representative Art Director Photographer'],
            ['id_contact_role' => 23, 'name' => 'Responsable  Marketing & négoce'],
            ['id_contact_role' => 24, 'name' => 'Responsable Achat'],
            ['id_contact_role' => 25, 'name' => 'Chargé d\'affaire'],
            ['id_contact_role' => 26, 'name' => 'Directeur réseau'],
            ['id_contact_role' => 27, 'name' => 'Directeur Technique et Achats'],
            ['id_contact_role' => 28, 'name' => 'Responsable communications marketing'],
            ['id_contact_role' => 29, 'name' => 'Chef de rayon '],
            ['id_contact_role' => 30, 'name' => 'Gestionnaire Approvisionnements'],
            ['id_contact_role' => 31, 'name' => 'Commercial'],
            ['id_contact_role' => 32, 'name' => 'Manager'],
            ['id_contact_role' => 33, 'name' => 'Directeur commercial'],
            ['id_contact_role' => 34, 'name' => 'Chef de Produit'],
            ['id_contact_role' => 35, 'name' => 'Responsable Logistique Magasin & Click & Collect'],
            ['id_contact_role' => 36, 'name' => 'cabinet comptable'],
            ['id_contact_role' => 37, 'name' => 'Manager Commerce'],
            ['id_contact_role' => 38, 'name' => 'Technicien Réparation Informatique'],
            ['id_contact_role' => 39, 'name' => 'Coordinateur Rayon'],
            ['id_contact_role' => 40, 'name' => 'Président'],
            ['id_contact_role' => 41, 'name' => 'Directeur Développement et Stratégie Marchés'],
        ]);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contact_roles');
    }
};