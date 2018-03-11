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
        DB::table('order_statuses')->insert([
        	['name' => 'pending'],
        	['name' => 'shipped'],
        	['name' => 'completed'],
        	['name' => 'returned'],
        	['name' => 'cancelled']
    	]);
    }
}
