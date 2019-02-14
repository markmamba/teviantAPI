<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveredAtInOrderCarriers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_carriers', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable()->default(null)->after('delivery_text');
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
            $table->dropColumn('delivered_at');
        });
    }
}
