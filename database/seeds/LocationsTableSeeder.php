<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $locations = [
        //     [
        //     	'name' => 'Warehouse 1',
        // 	],
        // 	[
        //     	'name' => 'Warehouse 2',
        // 	],
        // 	[
        //     	'name' => 'Branch 1',
        // 	],
        //     [
        //         'name' => 'Receivings',
        //     ],
        // ];
        
        $locations = [
            [
                'name' => 'Default Location',
            ],
        ];

        DB::table('locations')->insert($locations);
    }
}
