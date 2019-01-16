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
            	'name' => 'Default Supplier',
        	],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
