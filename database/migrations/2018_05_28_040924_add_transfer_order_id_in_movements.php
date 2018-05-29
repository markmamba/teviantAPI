<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransferOrderIdInMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_stock_movements', function (Blueprint $table) {
            $table->integer('transfer_order_id')->unsigned()->nullable()->default(null)->after('reason');
            $table->foreign('transfer_order_id')->references('id')->on('transfer_orders')
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
        Schema::table('inventory_stock_movements', function (Blueprint $table) {
            $table->dropForeign(['transfer_order_id']);
            $table->dropColumn('transfer_order_id');
        });
    }
}
