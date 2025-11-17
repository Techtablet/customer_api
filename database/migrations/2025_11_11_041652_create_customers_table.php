<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_customer')->primary();
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
            
            $table->string('name', 100);
            $table->string('siren', 32);
            $table->string('siret', 32);
            $table->integer('newsletter');
            $table->integer('alreadycalled');

            //franchise
            $table->unsignedBigInteger('id_franchise');
            $table->foreign('id_franchise')->references('id_franchise')->on('franchises')->onDelete('restrict');
            //stock_software
            $table->unsignedBigInteger('id_stock_software');
            $table->foreign('id_stock_software')->references('id_stock_software')->on('stock_softwares')->onDelete('restrict');

            $table->integer('to_callback');

            //status
            $table->unsignedBigInteger('id_status');
            $table->foreign('id_status')->references('id_customer_status')->on('customer_statuses')->onDelete('restrict');
            //refusal_reason
            $table->unsignedBigInteger('id_refusal_reason');
            $table->foreign('id_refusal_reason')->references('id_customer_refusal_reason')->on('customer_refusal_reasons')->onDelete('restrict');

            $table->tinyInteger('survey_actif')->default(1)->comment('1 : actif, 0 : inactif');
            $table->date('survey_date_disabled');
            $table->tinyInteger('important')->default(0)->comment('1 : important customer, 0: not important');
            $table->text('notes');
            $table->dateTime('reminder')->nullable();
            $table->integer('seller_reminder')->default(0);
           
            $table->unsignedBigInteger('id_seller');
            $table->foreign('id_seller')->references('id_techtablet_seller')->on('techtablet_sellers')->onDelete('restrict');
            
            $table->tinyInteger('repurchase_menu');
            $table->tinyInteger('dropshipping_menu');
            $table->float('dropshipping_fee');
            $table->tinyInteger('delivery_order')->default(1);
            $table->integer('profil')->default(0);
            $table->tinyInteger('information_request_send');
            $table->tinyInteger('information_request_validated');
            $table->tinyInteger('information_request_validated_once');
            $table->string('ape', 20);
            $table->string('rcs', 40);
            $table->tinyInteger('tourist_area')->default(2)->comment('2: PAS ENCORE DEMANDE, 0: NON, 1: OUI');
            $table->string('denomination', 50)->default('Formel');
            
            $table->unsignedBigInteger('id_store_group')->nullable()->default(0);
            $table->foreign('id_store_group')->references('id_store_group')->on('store_groups')->onDelete('restrict');
            
            $table->text('shipping_schedule');
            $table->tinyInteger('has_customer_order_number');
            $table->string('last_website_key', 500);
            $table->tinyInteger('receive_stock_software_file');
            $table->tinyInteger('stock_software_file_format')->default(1)->comment('1:Wingsm, 2:3gwin, 3:generique, 4: Trépidai');
            $table->string('supplier_id_for_techtablet', 250);
            $table->string('internal_customer_id', 30)->nullable();

            //id_lang
            $table->unsignedBigInteger('id_lang')->default(1);
            $table->foreign('id_lang')->references('id_customer_lang')->on('customer_langs')->onDelete('restrict');
            
            $table->unsignedBigInteger('id_shippingplan');
            $table->unsignedBigInteger('id_price_list_info');

            //id_location
            $table->unsignedBigInteger('id_location')->nullable()->default(0);
            $table->foreign('id_location')->references('id_customer_location')->on('customer_locations')->onDelete('restrict');

            //typologie
            $table->unsignedBigInteger('id_typologie')->nullable()->default(0);
            $table->foreign('id_typologie')->references('id_customer_typologie')->on('customer_typologies')->onDelete('restrict');
            
            //id_canvassing
            $table->unsignedBigInteger('id_canvassing_step')->default(0);
            $table->foreign('id_canvassing_step')->references('id_customer_canvassing_step')->on('customer_canvassing_steps')->onDelete('restrict');
            
            $table->tinyInteger('refund_by_ic')->default(0);
            $table->tinyInteger('repurchase_type')->default(0)->comment('0:standard, 1:100%');
            $table->tinyInteger('inactive')->default(0)->comment('1: signup not activate, 0: active');
            $table->tinyInteger('receive_credit_on_reprise_stock_validation')->default(1);
            $table->tinyInteger('featured_product')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
