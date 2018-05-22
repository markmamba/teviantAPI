<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderReceivingProduct;

class PurchaseOrderReceivingsProductsController extends Controller
{
    /**
     * Return the list of products from the receivings.
     * @return JSON
     */
    public function ajaxIndex()
    {
        $receivings_products = PurchaseOrderReceivingProduct::all();
        $receivings_products->map(function($receivings_product) {
            $receivings_product->quantity_transferrable = $receivings_product->quantity_transferrable;
            return $receivings_product;
        });

        return response()->json($receivings_products);
    }

    /**
     * Return a specific product.
     * @return JSON
     */
    public function ajaxShow($id)
    {
        $receivings_product = PurchaseOrderReceivingProduct::findOrFail($id);
        $receivings_product->quantity_transferrable = $receivings_product->quantity_transferrable;

        return response()->json($receivings_product);
    }
}
