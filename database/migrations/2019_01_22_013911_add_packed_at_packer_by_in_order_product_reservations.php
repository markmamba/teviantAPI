<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackedAtPackerByInOrderProductReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->timestamp('packed_at')->nullable()->default(null)->after('picked_by');
            $table->integer('packed_by')->unsigned()->nullable()->default(null)->after('packed_at');
            $table->foreign('packed_by')->references('id')->on('users')
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
            $table->dropForeign(['packed_by']);
            $table->dropColumn(['packed_at', 'packed_by']);
        });
    }
}
