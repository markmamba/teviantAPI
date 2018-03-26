<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeShipmentPackageDimensionsToNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shipments', function (Blueprint $table) {
            $table->decimal('package_length', 13,2)->after('order_id')->nullable()->change();
            $table->decimal('package_width', 13,2)->after('package_length')->nullable()->change();
            $table->decimal('package_height', 13,2)->after('package_width')->nullable()->change();
            $table->decimal('package_weight', 13,2)->after('package_height')->nullable()->change();
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
            $table->decimal('package_length', 13,2)->after('order_id')->nullable(false)->change();
            $table->decimal('package_width', 13,2)->after('package_length')->nullable(false)->change();
            $table->decimal('package_height', 13,2)->after('package_width')->nullable(false)->change();
            $table->decimal('package_weight', 13,2)->after('package_height')->nullable(false)->change();
        });
    }
}
