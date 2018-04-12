<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePurchaseOrderProductIdAndQuantityInPurchaseOrderReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_receivings', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_product_id']);
            $table->dropColumn(['quantity', 'purchase_order_product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_receivings', function (Blueprint $table) {
            $table->integer('purchase_order_product_id')->unsigned()->nullable()->default(null)->after('purchase_order_id');
            $table->foreign('purchase_order_product_id')->references('id')->on('purchase_order_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('quantity')->unsigned()->after('price')->after('purchase_order_product_id');
        });
    }
}
