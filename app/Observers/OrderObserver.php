<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderStatus;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Initialize the Ecommerce order statuses relative to our OMS' order statuses.
     * For the ecommerce app, let's assume it has the following status ids and names:
     *
     * 1 - Pending
     * 2 - Paid
     * 3 - Processing
     * 4 - Delivered
     * 5 - Done
     * 6 - Cancelled
     *
     * For the OMS app, we have:
     *
     * 1 - Pending
     * 2 - Pick Listed
     * 3 - Packed
     * 4 - Shipped
     * 5 - Delivered
     * 6 - Done
     * 7 - Cancelled
     *
     * IMPORTANT: If these are not true or has changed, please update here accordingly.
     */
    private $status_associations = [
        'Pending'    => ['Pending'],
        'Paid'       => ['Pending'],
        'Processing' => ['Pick Listed', 'Packed', 'Shipped'],
        'Delivered'  => ['Delivered'],
        'Done'       => ['Done'],
        'Cancelled'  => ['Cancelled'],
    ];

    /**
     * The order statuses of the Ecommerce app.
     * @var array
     */
    private $ecommerce_order_statuses = [
    	1 => 'Pending',
    	2 => 'Paid',
    	3 => 'Processing',
    	4 => 'Delivered',
    	5 => 'Done',
    	6 => 'Cancelled',
    ];

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

    // WIP
    public function saved(Order $order)
    {
        $order_statuses = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'))->toArray();
        $status_name = $order_statuses[request()->status_id];

        // Debug
    	// echo '<br>';
    	// echo 'status_id = ' . request()->status_id . ' | ' . $status_name;
        
        foreach ($this->status_associations as $key => $value) {
            // Debug
            // $matched = array_search($status_name, $value);
            // echo '<br> ';
            // echo $key . ' => ' . implode($value, ',') . ' | Searched: ' . $matched;
            
            // Search
            if (in_array($status_name, $value)) {
            	request()->status_id = collect($this->ecommerce_order_statuses)->search($key);
            	// Debug
				// echo '<br>';
				// echo 'Matched = ' . request()->status_id;
                break;
            }
        }
        // Debug
        // die();

        // Update the ecommerce through its API.
        try {
            $response = $this->ecommerce_client->patch('api/orders/' . $order->common_id, [
                'form_params' => request()->all(),
            ]);
            Log::info('Ecommerce order updated via API.');
        } catch (\Exception $e) {
            Log::alert('Failed to update order on the ecommerce API.', ['message' => $e->getMessage()]);
        }
    }
}
