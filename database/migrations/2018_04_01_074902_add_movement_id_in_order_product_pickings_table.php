<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMovementIdInOrderProductPickingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_pickings', function (Blueprint $table) {
            $table->integer('movement_id')->unsigned()->after('picked_at');
            $table->foreign('movement_id')->references('id')->on('inventory_stock_movements')
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
        Schema::table('order_product_pickings', function (Blueprint $table) {
            $table->dropForeign(['movement_id']);
            $table->dropColumn('movement_id');
        });
    }
}
