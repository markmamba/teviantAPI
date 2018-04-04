<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductPickings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_pickings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('reservation_id')->unsigned();
            $table->foreign('reservation_id')->references('id')->on('order_product_reservations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('quantity_picked')->unsigned();
            
            $table->integer('picker_id')->unsigned()->nullable()->default(null);
            $table->foreign('picker_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamp('picked_at');

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
        Schema::dropIfExists('order_product_pickings');
    }
}
