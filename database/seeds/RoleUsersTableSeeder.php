<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->delete();

        $roleUsers = [
            [
                'role_id' => DB::table('roles')->where('name', 'Super User')->first()->id,
                'user_id' => DB::table('users')->where('email', 'super_user@teviant.com')->first()->id,
            ],
            [
                'role_id' => DB::table('roles')->where('name', 'Administrator')->first()->id,
                'user_id' => DB::table('users')->where('email', 'admin@teviant.com')->first()->id,
            ],
            [
                'role_id' => DB::table('roles')->where('name', 'Inbound Operator')->first()->id,
                'user_id' => DB::table('users')->where('email', 'inbound@teviant.com')->first()->id,
            ],
            [
                'role_id' => DB::table('roles')->where('name', 'Outbound Operator')->first()->id,
                'user_id' => DB::table('users')->where('email', 'outbound@teviant.com')->first()->id,
            ],
        ];

        DB::table('role_users')->insert($roleUsers);
    }
}
