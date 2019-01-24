<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('sales_invoice_number');
            $table->string('tracking_number');

            $table->integer('order_carrier_id')->unsigned()->nullable()->default(null);
            $table->foreign('order_carrier_id')
                ->references('id')
                ->on('order_carriers')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            
            $table->timestamp('shipped_at')->nullable()->default(null);
            $table->timestamp('delivered_at')->nullable()->default(null);

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
        Schema::dropIfExists('order_packages');
    }
}
