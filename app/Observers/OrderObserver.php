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
            // 'timeout'  => 2.0,
        ]);
    }

    public function updated(Order $order)
    {
        $this->updateRemoteOrder($order);
        $this->updateRemoteOrderProducts($order);
    }

    protected function updateRemoteOrder($order)
    {
        $order_statuses = collect(OrderStatus::orderBy('id', 'asc')->pluck('name', 'id'))->toArray();
        
        // Get the status Id from request() if its updated via form submit or via programatically.
        $status_name = $order_statuses[isset(request()->status_id) ? request()->status_id : $order->status_id];
        // The associated ecommerce status_id
        $status_id = null;
        
        foreach ($this->status_associations as $key => $value) {
            // Search
            if (in_array($status_name, $value)) {
                $status_id = collect($this->ecommerce_order_statuses)->search($key);
                break;
            }
        }

        // Update the ecommerce through its API.
        try {
            $response = $this->ecommerce_client->patch('api/orders/' . $order->common_id, [
                'form_params' => [
                    'status_id' => $status_id,
                ],
            ]);
            Log::info('Ecommerce order updated via API.');
        } catch (\Exception $e) {
            Log::alert('Failed to update order on the ecommerce API.', ['message' => $e->getMessage()]);
        }
    }

    /**
     * @param  App\Models\Inventory $products
     * @return void
     */
    protected function updateRemoteOrderProducts($order)
    {
        foreach ($order->products as $product) {
            // Update the ecommerce through its API.
            try {
                $response = $this->ecommerce_client->patch('api/products/' . $product->common_id, [
                    'form_params' => [
                        'stock' => $product->product->stock
                    ],
                ]);
                Log::info('Updated Ecommerce product via API.');
            } catch (\Exception $e) {
                Log::alert('Failed to update the product on the ecommerce API.', ['message' => $e->getMessage()]);
            }
        }
    }
}
