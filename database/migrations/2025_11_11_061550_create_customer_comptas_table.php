<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_comptas', function (Blueprint $table) {
            $table->id('id_customer_compta');

            $table->unsignedBigInteger('id_customer')->unique();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            
            $table->char('devise', 5)->default('EUR'); // longueur fixe
            $table->string('tva_intra_number', 75)->nullable();    // longueur variable
            $table->integer('payment_mode');
            $table->char('rib_etablissement', 16)->nullable();     // longueur fixe
            $table->char('rib_guichet', 16)->nullable();
            $table->char('rib_compte', 16)->nullable();
            $table->char('rib_cle', 16)->nullable();
            $table->integer('discount')->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->boolean('shipping_invoice')->default(true);
            $table->float('en_cours')->default(0);
            $table->integer('future_payment_mode')->nullable();
            $table->string('future_payment_delay_type', 11); // longueur variable, pas fixe
            $table->integer('future_payment_delay')->nullable();
            $table->integer('rolling_period_days')->nullable()->comment("Nombre de jours d'une periode glissante");
            $table->decimal('rolling_period_amount', 15, 2)->nullable()->comment("Montant pour une periode glissante");
            $table->date('rolling_period_cron_date')->nullable()->comment("Date Cron pour une periode glissante");
            $table->string('bic', 500)->nullable();
            $table->string('iban', 500)->nullable();
            $table->boolean('grouped_invoice')->default(false);
            $table->date('grouped_invoice_begin')->nullable();
            $table->date('grouped_invoice_end')->nullable();
            $table->boolean('cb_register_info')->default(false);
            $table->boolean('cb_register_always_ask')->default(true);
            $table->string('cb_token', 250)->nullable();
            $table->char('cb_date_val', 4)->nullable(); // longueur fixe
            $table->string('cb_ref_abonne', 250)->nullable();
            $table->char('sepa_mandat_reference', 20)->nullable(); // longueur fixe
            $table->string('sepa_payment_type', 50)->default('REPETITIVE')->comment('VALUES: REPETITIVE, UNIQUE');
            $table->string('sepa_debtor_name', 150)->nullable();
            $table->string('sepa_debtor_address', 250)->nullable();
            $table->string('sepa_debtor_address_pc', 64)->nullable();
            $table->string('sepa_debtor_address_city', 75)->nullable();
            $table->string('sepa_signature_location', 75)->nullable();
            $table->date('sepa_signature_date')->nullable();
            $table->boolean('sepa_request_validated')->default(false);
            $table->boolean('sepa_request_validated_once')->default(false);
            $table->boolean('is_blprice')->default(false);
            $table->boolean('classic_invoice')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_comptas');
    }
};
