<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderReceivingProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_receiving_products', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('purchase_order_receiving_id')->unsigned();
            $table->foreign('purchase_order_receiving_id', 'receiving_id_foreign')->references('id')->on('purchase_order_receivings')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            
            $table->integer('purchase_order_product_id')->unsigned();
            $table->foreign('purchase_order_product_id', 'product_id_foreign')->references('id')->on('purchase_order_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            
            $table->integer('quantity')->unsigned();

            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::dropIfExists('purchase_order_receiving_products');
    }
}
