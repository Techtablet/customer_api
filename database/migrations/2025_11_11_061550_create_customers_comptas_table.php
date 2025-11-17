<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers_comptas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer_compta')->primary();

            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('restrict');
            
            $table->char('devise', 5)->default('EUR'); // longueur fixe
            $table->string('tva_intra_number', 75);    // longueur variable
            $table->integer('payment_mode');
            $table->char('rib_etablissement', 16);     // longueur fixe
            $table->char('rib_guichet', 16);
            $table->char('rib_compte', 16);
            $table->char('rib_cle', 16);
            $table->integer('discount')->default(0);
            $table->float('balance');
            $table->tinyInteger('shipping_invoice')->default(1);
            $table->float('en_cours');
            $table->integer('future_payment_mode');
            $table->string('future_payment_delay_type', 11); // longueur variable, pas fixe
            $table->integer('future_payment_delay');
            $table->integer('rolling_period_days')->nullable()->comment("Nombre de jours d'une periode glissante");
            $table->float('rolling_period_amount')->nullable()->comment("Montant pour une periode glissante");
            $table->date('rolling_period_cron_date')->nullable()->comment("Date Cron pour une periode glissante");
            $table->string('bic', 500)->nullable();
            $table->string('iban', 500)->nullable();
            $table->tinyInteger('grouped_invoice');
            $table->date('grouped_invoice_begin');
            $table->date('grouped_invoice_end');
            $table->tinyInteger('cb_register_info');
            $table->tinyInteger('cb_register_always_ask')->default(1);
            $table->string('cb_token', 250);
            $table->char('cb_date_val', 4); // longueur fixe
            $table->string('cb_ref_abonne', 250);
            $table->char('sepa_mandat_reference', 20); // longueur fixe
            $table->string('sepa_payment_type', 50)->default('REPETITIVE')->comment('VALUES: REPETITIVE, UNIQUE');
            $table->string('sepa_debtor_name', 150);
            $table->string('sepa_debtor_address', 250);
            $table->string('sepa_debtor_address_pc', 64);
            $table->string('sepa_debtor_address_city', 75);
            $table->string('sepa_signature_location', 75);
            $table->date('sepa_signature_date');
            $table->tinyInteger('sepa_request_validated');
            $table->tinyInteger('sepa_request_validated_once');
            $table->tinyInteger('is_blprice')->default(0);
            $table->tinyInteger('classic_invoice')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers_comptas');
    }
};
