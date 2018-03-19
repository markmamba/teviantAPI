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
        DB::table('order_statuses')->delete();

        $order_statuses = [
            ['id' => 1, 'name' => 'Pending'],
            ['id' => 2, 'name' => 'Processed'],
            ['id' => 3, 'name' => 'Delivered'],
            ['id' => 4, 'name' => 'Done'],
            ['id' => 5, 'name' => 'Cancelled'],
        ];

        DB::table('order_statuses')->insert($order_statuses);
    }
}
