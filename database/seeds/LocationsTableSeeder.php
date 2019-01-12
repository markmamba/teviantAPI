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
        $locations = [
            [
                'name' => 'Receivings',
            ],
            [
                'name' => 'Default',
            ],
        ];

        DB::table('locations')->insert($locations);
    }
}
