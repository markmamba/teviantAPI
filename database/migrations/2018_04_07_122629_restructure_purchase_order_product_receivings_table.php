<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructurePurchaseOrderProductReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_product_receivings', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        Schema::rename('purchase_order_product_receivings', 'purchase_order_receivings');

        Schema::table('purchase_order_receivings', function (Blueprint $table) {
            $table->integer('purchase_order_id')->unsigned()->after('id');
            $table->integer('purchase_order_product_id')->unsigned()->nullable()->default(null)->after('purchase_order_id');

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('purchase_order_product_id')->references('id')->on('purchase_order_products')
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
        Schema::table('purchase_order_receivings', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_id']);
            $table->dropForeign(['purchase_order_product_id']);
            $table->dropColumn(['purchase_order_id', 'purchase_order_product_id']);
        });

        Schema::rename('purchase_order_receivings', 'purchase_order_product_receivings');

        Schema::table('purchase_order_product_receivings', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->after('id');
            $table->foreign('product_id')->references('id')->on('purchase_order_products')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }
}
