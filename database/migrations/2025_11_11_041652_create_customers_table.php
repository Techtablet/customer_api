<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id_customer');
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
            //$table->foreignId('id_user')->constrained('users')->restrictOnDelete();
            
            $table->string('name', 100);
            $table->string('siren', 32);
            $table->string('siret', 32);
            $table->unsignedTinyInteger('newsletter')->default(0);
            //alreadycalled
            $table->boolean('already_called')->default(0)->comment('Anciennement alreadycalled');;

            //franchise
            $table->unsignedBigInteger('id_franchise')->nullable();
            $table->foreign('id_franchise')->references('id_franchise')->on('franchises')->onDelete('restrict');
            //stock_software
            $table->unsignedBigInteger('id_stock_software')->nullable();
            $table->foreign('id_stock_software')->references('id_stock_software')->on('stock_softwares')->onDelete('restrict');

            $table->boolean('to_callback');

            //status
            $table->integer('id_status');
            $table->foreign('id_status')->references('id_customer_status')->on('customer_statuses')->onDelete('restrict');
            //refusal_reason
            $table->unsignedBigInteger('id_refusal_reason')->nullable();
            $table->foreign('id_refusal_reason')->references('id_customer_refusal_reason')->on('customer_refusal_reasons')->onDelete('restrict');

            $table->boolean('survey_actif')->default(1)->comment('1 : actif, 0 : inactif');
            $table->date('survey_date_disabled')->nullable();
            $table->boolean('important')->default(0)->comment('1 : important customer, 0: not important');
            $table->text('notes');
            $table->dateTime('reminder')->nullable();
            $table->integer('seller_reminder')->default(0);
           
            $table->unsignedBigInteger('id_seller')->nullable();
            $table->foreign('id_seller')->references('id_techtablet_seller')->on('techtablet_sellers')->onDelete('restrict');
            
            $table->boolean('repurchase_menu')->default(0);
            $table->boolean('dropshipping_menu')->default(0);
            $table->decimal('dropshipping_fee',15,2);
            $table->boolean('delivery_order')->default(1);
            $table->integer('profil')->default(0);
            $table->boolean('information_request_send')->default(0);
            $table->boolean('information_request_validated')->default(0);
            $table->boolean('information_request_validated_once')->default(0);
            $table->string('ape', 20)->nullable();
            $table->string('rcs', 40)->nullable();
            $table->tinyInteger('tourist_area')->default(2)->comment('2: PAS ENCORE DEMANDE, 0: NON, 1: OUI');
            $table->string('denomination', 50)->default('Formel');
            
            $table->unsignedBigInteger('id_store_group')->nullable();
            $table->foreign('id_store_group')->references('id_store_group')->on('store_groups')->onDelete('restrict');
            
            $table->text('shipping_schedule')->comment('exemple de valeur ["1", "2", "3", "4", "5", "6", "7"]');
            $table->boolean('has_customer_order_number')->default(0);
            $table->string('last_website_key', 500)->nullable();
            $table->boolean('receive_stock_software_file')->default(0);
            $table->tinyInteger('stock_software_file_format')->default(1)->comment('1:Wingsm, 2:3gwin, 3:generique, 4: Trépidai');
            $table->string('supplier_id_for_techtablet', 250)->nullable();
            $table->string('internal_customer_id', 30)->nullable();

            //id_lang
            $table->unsignedBigInteger('id_lang')->default(1);
            $table->foreign('id_lang')->references('id_customer_lang')->on('customer_langs')->onDelete('restrict');
            
            $table->unsignedBigInteger('id_shipping_plan');
            $table->unsignedBigInteger('id_price_list_info');

            //id_location
            $table->unsignedBigInteger('id_location')->nullable();
            $table->foreign('id_location')->references('id_customer_location')->on('customer_locations')->onDelete('restrict');

            //typologie
            $table->unsignedBigInteger('id_typology')->nullable()->comment('Anciennement typologie');
            $table->foreign('id_typology')->references('id_customer_typology')->on('customer_typologies')->onDelete('restrict');
            
            //id_canvassing
            $table->unsignedBigInteger('id_canvassing_step')->nullable()->comment('Anciennement id_canvassing');
            $table->foreign('id_canvassing_step')->references('id_customer_canvassing_step')->on('customer_canvassing_steps')->onDelete('restrict');
            
            $table->boolean('refund_by_ic')->default(0);
            $table->boolean('repurchase_type')->default(0)->comment('0:standard, 1:100%');
            $table->boolean('inactive')->default(0)->comment('1: signup not activate, 0: active');
            $table->boolean('receive_credit_on_reprise_stock_validation')->default(1);
            $table->boolean('featured_product')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
