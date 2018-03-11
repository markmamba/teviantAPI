<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the default status (pending)
        $pending_status = DB::table('order_statuses')->where('name', 'pending')->first();

        Schema::table('orders', function (Blueprint $table) use ($pending_status) {
            $table->integer('status_id')->unsigned()->after('common_id')->default($pending_status->id);
            $table->foreign('status_id')
                ->references('id')
                ->on('order_statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
        });
    }
}
