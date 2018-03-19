<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_reservations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_product_id')->unsigned();
            $table->foreign('order_product_id')->references('id')->on('order_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('inventory_stocks')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('quantity_reserved')->unsigned();
            $table->integer('quantity_taken')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_reservations');
    }
}
