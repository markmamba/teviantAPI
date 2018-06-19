<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplacePurchaseOrderReceivingProductIdWithPurchaseOrderProductIdInTransferOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_orders', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_receiving_product_id']);
            $table->dropColumn(['purchase_order_receiving_product_id']);

            $table->integer('purchase_order_product_id')->unsigned()->after('id');
            $table->foreign('purchase_order_product_id')
                ->references('id')
                ->on('purchase_order_products')
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
        Schema::table('transfer_orders', function (Blueprint $table) {
            $table->integer('purchase_order_receiving_product_id')->unsigned()->after('id');
            $table->foreign('purchase_order_receiving_product_id')
                ->references('id')
                ->on('purchase_order_receiving_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->dropForeign(['purchase_order_product_id']);
            $table->dropColumn(['purchase_order_product_id']);
        });
    }
}
