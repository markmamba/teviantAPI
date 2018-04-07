<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplacePurchaseOrderIdWithOrderPurchaseOrderProductIdInPurchaseProductReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_product_receivings', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);
            $table->dropColumn(['purchase_order_id']);

            $table->integer('product_id')->unsigned()->after('id');
            $table->foreign('product_id')->references('id')->on('purchase_order_products')
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
        Schema::table('purchase_order_product_receivings', function (Blueprint $table) {
            $table->integer('purchase_order_id')->unsigned()->after('id');
            
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
        });
    }
}
