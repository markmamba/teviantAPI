<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if (App::isLocal()) {
            // Truncate orders and its associated tables
            Schema::disableForeignKeyConstraints();
            // DB::table('order_billing_addresses')->truncate();
            // DB::table('order_shipping_addresses')->truncate();
            DB::table('order_carriers')->truncate();
            DB::table('order_shipments')->truncate();
            DB::table('order_products')->truncate();
            DB::table('order_product_reservations')->truncate();
            DB::table('order_users')->truncate();
            DB::table('orders')->truncate();
            DB::table('order_statuses')->truncate();
            DB::table('users')->truncate();
            Schema::enableForeignKeyConstraints();
        }

    	$default_admin_password = null !== env('DEFAULT_ADMIN_PASSWORD') ? env('DEFAULT_ADMIN_PASSWORD') : 'password';

        $users = [
            [
                'name' => 'Super User',
                'email' => 'super_user@teviant.com',
                'password' => bcrypt($default_admin_password),
            ],
            [
            	'name' => 'Teviant Admin',
            	'email' => 'admin@teviant.com',
            	'password' => bcrypt($default_admin_password),
        	],
            [
                'name' => 'Inbound Operator',
                'email' => 'inbound@teviant.com',
                'password' => bcrypt($default_admin_password),
            ],
        	[
            	'name' => 'Outbound Operator',
            	'email' => 'outbound@teviant.com',
            	'password' => bcrypt($default_admin_password),
        	],
        ];

        DB::table('users')->insert($users);
    }
}
