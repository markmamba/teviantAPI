<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('purchase_order_receiving_product_id')->unsigned();
            $table->foreign('purchase_order_receiving_product_id')
                ->references('id')
                ->on('purchase_order_receiving_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            
            $table->string('ailse')->nullable()->default(null);
            $table->string('row')->nullable()->default(null);
            $table->string('bin')->nullable()->default(null);

            $table->integer('quantity')->unsigned();
            $table->string('remark')->nullable()->default(null);

            $table->datetime('transferred_at')->nullable()->default(null);

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
        Schema::dropIfExists('transfer_orders');
    }
}
