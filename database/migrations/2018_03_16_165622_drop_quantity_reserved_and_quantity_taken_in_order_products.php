<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropQuantityReservedAndQuantityTakenInOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn(['quantity_reserved', 'quantity_taken']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->integer('quantity_reserved')->unsigned()->default(0)->after('quantity');
            $table->integer('quantity_taken')->unsigned()->default(0)->after('quantity_reserved');
        });
    }
}
