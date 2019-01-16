<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOrderBillingAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('order_billing_addresses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('order_billing_addresses', function (Blueprint $table) {
            $table->increments('id');

            // The unique ID from the ecommerce API.
            $table->integer('common_id')->unsigned();

            // Will remove these once available on the API.
            $table->string('name');
            $table->string('address1');
            $table->string('address2');
            $table->string('county');
            $table->string('city');
            $table->string('postal_code');
            $table->string('phone');
            $table->string('mobile_phone');

            $table->timestamps();
        });
    }
}
