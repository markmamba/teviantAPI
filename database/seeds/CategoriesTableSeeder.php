<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        	[
            	'name' => 'Lipstick',
        	],
        	[
            	'name' => 'Food',
        	],
        	[
            	'name' => 'Beverage',
        	],
        ];

        DB::table('categories')->insert($categories);
    }
}
