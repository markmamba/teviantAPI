<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderProduct;

class PurchaseOrderProductsController extends Controller
{
    /**
     * Return the list of products from the receivings.
     * @return JSON
     */
    public function ajaxIndex()
    {   
        $product_groups = PurchaseOrderProduct::getGroups()->map(function($product_group){
            // dd($product_group);
            return $product_group->map(function($product) use ($product_group){
                $product->product_id              = $product_group->product_id;
                $product->name                    = $product_group->name;
                $product->sku                     = $product_group->sku;
                $product->total_quantity_ordered  = $product_group->total_quantity_ordered;
                $product->total_quantity_received = $product_group->total_quantity_received;
                $product->total_quantity_transferred = $product_group->total_quantity_transferred;
                $product->total_quantity_transferrable = $product_group->total_quantity_transferrable;

                return $product;
            });
        })->values();

        $product_groups = $product_groups->map(function($product_group){
            return [
                'product_id'                   => $product_group->first()->product_id,
                'total_quantity_transferrable' => $product_group->first()->total_quantity_transferrable,
            ];
        });

        // Set a single collection for all groups products.
        $product_groups_products = collect();
        foreach ($product_groups as $product_group) {
            foreach ($product_group as $product) {
                $product_groups_products->push($product);
            }
        }

        // dd($product_groups, $product_groups_products);

        return response()->json($product_groups);
    }

    /**
     * Return a specific product.
     * @return JSON
     */
    public function ajaxShow($id)
    {
        $product                         = PurchaseOrderProduct::findOrFail($id);
        $product->quantity_transferrable = $product->quantity_transferrable;

        return response()->json($product);
    }
}
