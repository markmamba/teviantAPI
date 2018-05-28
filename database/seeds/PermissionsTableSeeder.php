<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('permissions')->delete();

    	$permissions = [
    		// Metrics
    		['name' => 'metrics.index'],
            ['name' => 'metrics.create'],
            ['name' => 'metrics.show'],
            ['name' => 'metrics.update'],
            ['name' => 'metrics.delete'],

            // Categories
    		['name' => 'categories.index'],
            ['name' => 'categories.create'],
            ['name' => 'categories.show'],
            ['name' => 'categories.update'],
            ['name' => 'categories.delete'],

            // Locations
    		['name' => 'locations.index'],
            ['name' => 'locations.create'],
            ['name' => 'locations.show'],
            ['name' => 'locations.update'],
            ['name' => 'locations.delete'],

            // Inventories
    		['name' => 'inventories.index'],
            ['name' => 'inventories.create'],
            ['name' => 'inventories.show'],
            ['name' => 'inventories.update'],
            ['name' => 'inventories.delete'],

            // Stocks
    		['name' => 'stocks.index'],
            ['name' => 'stocks.create'],
            ['name' => 'stocks.store'],
            ['name' => 'stocks.show'],
            ['name' => 'stocks.update'],
            ['name' => 'stocks.delete'],
            ['name' => 'stocks.add'],
            ['name' => 'stocks.subtract'],

            // Movements
    		['name' => 'movements.index'],
            ['name' => 'movements.show'],
            ['name' => 'movements.rollback'],

            // Suppliers
    		['name' => 'suppliers.index'],
            ['name' => 'suppliers.create'],
            ['name' => 'suppliers.show'],
            ['name' => 'suppliers.update'],
            ['name' => 'suppliers.delete'],

        	// Roles
    		['name' => 'roles.index'],
            ['name' => 'roles.create'],
            ['name' => 'roles.show'],
            ['name' => 'roles.update'],
            ['name' => 'roles.delete'],

            // Permissions
    		['name' => 'permissions.index'],
            ['name' => 'permissions.create'],
            ['name' => 'permissions.show'],
            ['name' => 'permissions.update'],
            ['name' => 'permissions.delete'],

            // Users
    		['name' => 'users.index'],
            ['name' => 'users.create'],
            ['name' => 'users.show'],
            ['name' => 'users.update'],
            ['name' => 'users.delete'],

            // Orders
    		['name' => 'orders.index'],
    		['name' => 'orders.show'],
    		['name' => 'orders.update'],
            ['name' => 'orders.sync'],
            ['name' => 'orders.reopen'],
            ['name' => 'orders.pack'],
            ['name' => 'orders.ship'],
            ['name' => 'orders.cancel'],

            // Purchase Orders
    		['name' => 'purchase_orders.index'],
            ['name' => 'purchase_orders.create'],
            ['name' => 'purchase_orders.show'],

            // Receivings
    		['name' => 'receivings.index'],
            ['name' => 'receivings.create'],
            ['name' => 'receivings.show'],

            // Transfer Orders
            ['name' => 'transfer_orders.index'],
            ['name' => 'transfer_orders.create'],
            ['name' => 'transfer_orders.delete'],
    	];

    	DB::table('permissions')->insert($permissions);
    }
}
