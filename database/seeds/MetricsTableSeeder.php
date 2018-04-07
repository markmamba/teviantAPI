<?php

use Illuminate\Database\Seeder;

class MetricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metrics = [
        	[
            	'name' => 'Kilogram',
            	'symbol' => 'kg',
        	],
        	[
            	'name' => 'Liter',
            	'symbol' => 'l',
        	],
        	[
            	'name' => 'Piece',
            	'symbol' => 'pc',
        	],
        ];

        DB::table('metrics')->insert($metrics);
    }
}
