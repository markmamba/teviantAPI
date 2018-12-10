<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        // Seed permissions
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionRolesTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);

        // Temporarily login a user needed for the seeds.
        Auth::login(User::first());

        $this->call(OrderStatusesTableSeeder::class);
        $this->call(MetricsTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        // $this->call(InventoriesTableSeeder::class);
        // $this->call(SuppliersTableSeeder::class);
        // $this->call(InventoryStocksTableSeeder::class);

        Auth::logout();
    }
}
