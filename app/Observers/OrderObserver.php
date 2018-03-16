<?php

namespace App\Observers;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
	public function __construct()
	{
		// The HTTP client for the ecommerce API.
        $this->ecommerce_client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('ECOMMERCE_BASE_URI'),
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
	}

	public function saved(Order $order)
	{
		// Update the ecommerce through its API.
		try {
			$response = $this->ecommerce_client->patch('api/orders/'.$order->common_id, [
				'form_params' => request()->all()
			]);
			Log::info('Ecommerce order updated via API.');
		} catch (\Exception $e) {
			Log::alert('Failed to update order on the ecommerce API.', ['message' => $e->getMessage()]);
		}

    	// dd(json_decode($response->getBody()));
	}
}