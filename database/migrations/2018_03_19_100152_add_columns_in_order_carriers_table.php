<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInOrderCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_carriers', function (Blueprint $table) {
            // Carrier
            $table->integer('order_id')->unsigned()->after('id');
            $table->foreign('order_id')->references('id')->on('orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('name')->after('order_id');
            $table->decimal('price', 13,2)->after('name');
            $table->string('delivery_text')->nullable()->default(null)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_carriers', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'name', 'price', 'delivery_text']);
        });
    }
}
