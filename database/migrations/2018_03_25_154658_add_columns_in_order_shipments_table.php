<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInOrderShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shipments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id']);
        });

        // Lets add 1-1 package details for the shipment, later, we'll migrate to 1-n.
        Schema::table('order_shipments', function (Blueprint $table) {
            $table->decimal('package_length', 13,2)->after('order_id');
            $table->decimal('package_width', 13,2)->after('package_length');
            $table->decimal('package_height', 13,2)->after('package_width');
            $table->decimal('package_weight', 13,2)->after('package_height');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_shipments', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('order_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('order_shipments', function (Blueprint $table) {
            $table->dropColumn(['package_length', 'package_width', 'package_height', 'package_weight']);
        });
    }
}
