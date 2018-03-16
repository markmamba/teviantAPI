<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderIdToOrderBillingAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_billing_addresses', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->after('id');
            $table->foreign('order_id')->references('id')->on('orders')
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
        Schema::table('order_billing_addresses', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
    }
}
