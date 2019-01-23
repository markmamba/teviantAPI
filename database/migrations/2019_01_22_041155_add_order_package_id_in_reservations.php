<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderPackageIdInReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product_reservations', function (Blueprint $table) {
            $table->integer('order_package_id')->unsigned()->nullable()->default(null)->after('packed_by');
            $table->foreign('order_package_id')
                ->references('id')
                ->on('order_packages')
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
            $table->dropForeign(['order_package_id']);
            $table->dropColumn(['order_package_id']);
        });
    }
}
