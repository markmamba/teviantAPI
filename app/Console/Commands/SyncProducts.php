<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use DB;
use GuzzleHttp\Client;
use App\Models\Location;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync app\'s products with the Ecommerce Admin/CMS app.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->ecommerce_client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('ECOMMERCE_BASE_URI'),
            // You can set any number of default request options.
            // 'timeout'  => 2.0,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Syncing products...");

        try {
            $response = $this->ecommerce_client->get('api/products');
            $products = json_decode($response->getBody(), true);
            $bar = $this->output->createProgressBar(count($products) - DB::table('inventories')->whereIn('name', array_column($products, 'name'))->count());
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        foreach ($products as $product) {
            // Skip existing product
            if (DB::table('inventories')->where('name', $product['name'])->first())
                continue;

            DB::table('inventories')->insert(collect($product)
                ->only(DB::getSchemaBuilder()->getColumnListing('inventories'))
                ->merge(['metric_id' => DB::table('metrics')->where('name', 'Piece')->first()->id])
                ->toArray()
            );

            // Create SKU for the product
            $inventory = Inventory::find($product['id']);
            $inventory->createSku($product['sku']);

            // Create stock for the product on default location.
            $location = Location::first();
            $inventory->createStockOnLocation($product['stock'], $location);

            $bar->advance();
        }

        $bar->finish(PHP_EOL);

        $this->info("\nDone...");
    }
}
