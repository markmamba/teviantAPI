<?php

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Metric;
use App\User;
use Illuminate\Database\Seeder;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demo_category = Category::where('name', 'Food')->first();
        $demo_metric   = Metric::where('name', 'Piece')->first();
        $demo_user     = User::first();

        $inventories = [
            [
                'name'        => 'Lipstick',
                'price'       => 999,
                'category_id' => $demo_category->id,
                'metric_id'   => $demo_metric->id,
                'user_id'     => $demo_user->id,
            ],
            [
                'name'        => 'Apple',
                'price'       => 100,
                'category_id' => $demo_category->id,
                'metric_id'   => $demo_metric->id,
                'user_id'     => $demo_user->id,
            ],
            [
                'name'        => 'Banana',
                'price'       => 120,
                'category_id' => $demo_category->id,
                'metric_id'   => $demo_metric->id,
                'user_id'     => $demo_user->id,
            ],
            [
                'name'        => 'Cassava',
                'price'       => 280,
                'category_id' => $demo_category->id,
                'metric_id'   => $demo_metric->id,
                'user_id'     => $demo_user->id,
            ],
        ];

        DB::table('inventories')->insert($inventories);

        foreach (Inventory::all() as $inventory) {
            if ($inventory->name != 'Lipstick') {
                $inventory->regenerateSku();
            } else {
                $inventory->createSku('1000');
            }

        }
    }
}
