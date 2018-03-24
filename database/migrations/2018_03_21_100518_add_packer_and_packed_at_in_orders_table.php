<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackerAndPackedAtInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('packer')->unsigned()->nullable()->default(null)->after('status_id');
            $table->foreign('packer')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamp('packed_at')->nullable()->default(null)->after('packer');
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
            $table->dropForeign(['packer']);
            $table->dropColumn(['packer', 'packed_at']);
        });
    }
}
