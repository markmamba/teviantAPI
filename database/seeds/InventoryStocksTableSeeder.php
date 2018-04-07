<?php

use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\Location;
use Illuminate\Database\Seeder;

class InventoryStocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            InventoryStock::create(
                collect([
                    'inventory_id' => $inventory->id,
                    'location_id'  => Location::inRandomOrder()->first()->id,
                    'quantity'     => collect([5, 10, 50, 100, 200])->random(),
                    'aisle'        => '1',
                    'row'          => '2',
                    'bin'          => '3',
                ])->toArray()
            );
        }
    }
}
