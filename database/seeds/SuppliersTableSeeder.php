<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
        	[
            	'name' => 'Good Supplier',
        	],
        	[
            	'name' => 'Better Supplier',
        	],
        	[
            	'name' => 'Best Supplier',
        	],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
