<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('roles')->delete();

    	$roles = [
    		['name'  => 'Super User'],
            ['name'  => 'Administrator'],
            ['name'  => 'Inbound Operator'],
            ['name'  => 'Outbound Operator'],
    	];

    	DB::table('roles')->insert($roles);
    }
}
