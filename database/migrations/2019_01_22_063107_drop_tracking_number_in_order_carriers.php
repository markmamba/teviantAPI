<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTrackingNumberInOrderCarriers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_carriers', function (Blueprint $table) {
            $table->dropColumn('tracking_number'); 
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
            $table->string('tracking_number')->after('order_id');
        });
    }
}
