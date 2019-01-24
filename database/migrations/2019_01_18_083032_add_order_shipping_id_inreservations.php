<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderShippingIdInreservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->integer('order_carrier_id')->unsigned()->nullable()->default(null)->after('picked_by');
            $table->foreign('order_carrier_id')
                ->references('id')
                ->on('order_carriers')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
            $table->dropForeign(['order_carrier_id']);
            $table->dropColumn(['order_carrier_id']);
        });
    }
}
