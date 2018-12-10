<?php

namespace App\Console\Commands;

use App\Models\Category;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SyncCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync app\'s categories with the Ecommerce Admin/CMS app.';

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
        $this->info("Syncing categories...");

        try {
            $response = $this->ecommerce_client->get('api/categories');
            $categories = json_decode($response->getBody(), true);
            $bar = $this->output->createProgressBar(count($categories) - DB::table('categories')->whereIn('name', array_column($categories, 'name'))->count());
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        foreach ($categories as $category) {
            // Skip existing category
            if (DB::table('categories')->where('name', $category['name'])->first())
                continue;

            $bar->advance();
            DB::table('categories')->insert($category);
        }

        $bar->finish(PHP_EOL);

        $this->info("\nDone...");
    }
}
