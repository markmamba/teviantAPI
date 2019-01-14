<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // On local environment only
        if (App::isLocal()) {
            // Truncate orders and its associated tables
            Schema::disableForeignKeyConstraints();
            // DB::table('order_billing_addresses')->truncate();
            // DB::table('order_shipping_addresses')->truncate();
            DB::table('order_carriers')->truncate();
            DB::table('order_shipments')->truncate();
            DB::table('order_products')->truncate();
            DB::table('order_product_reservations')->truncate();
            DB::table('order_users')->truncate();
            DB::table('orders')->truncate();
            DB::table('order_statuses')->truncate();
            Schema::enableForeignKeyConstraints();
        }
        
        $order_statuses = [
            ['name' => 'Pending'],
            ['name' => 'Pick Listed'],
            ['name' => 'Packed'],
            ['name' => 'Shipped'],
            ['name' => 'Delivered'],
            ['name' => 'Done'],
            ['name' => 'Cancelled'],
        ];

        DB::table('order_statuses')->insert($order_statuses);
    }
}
