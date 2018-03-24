<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickedAtAndPickedByInOrderProductReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->timestamp('picked_at')->nullable()->default(null)->after('quantity_taken');
            $table->integer('picked_by')->unsigned()->nullable()->default(null)->after('picked_at');
            $table->foreign('picked_by')->references('id')->on('users')
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
            $table->dropForeign(['picked_by']);
            $table->dropColumn(['picked_at', 'picked_by']);
        });
    }
}
