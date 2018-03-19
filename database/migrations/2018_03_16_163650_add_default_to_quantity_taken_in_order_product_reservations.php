<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultToQuantityTakenInOrderProductReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->integer('quantity_taken')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->integer('quantity_taken')->default(null)->change();
        });
    }
}
