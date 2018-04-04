<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderProductReceivings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_product_receivings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('purchase_order_id')->unsigned();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('quantity')->unsinged();
            $table->timestamp('received_at');

            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('remark')->nullable()->default(null);

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
        Schema::dropIfExists('purchase_order_product_receivings');
    }
}
