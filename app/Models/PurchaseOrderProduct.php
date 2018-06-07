<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
    protected $fillable = [
        'product_id',
        'purchase_order_id',
        'price',
        'quantity',
        'completed_at',
    ];

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'product_id');
    }

    /**
     * Alias receiving_products()
     */
    public function receivings()
    {
        return $this->hasMany('App\Models\PurchaseOrderReceivingProduct', 'purchase_order_product_id');
    }

    /**
     * Alias receiving_products()
     */
    public function receiving_products()
    {
        return $this->hasMany('App\Models\PurchaseOrderReceivingProduct');
    }

    public function transfer_orders()
    {
        return $this->hasMany('App\Models\TransferOrder');
    }

    /**
     * Return quantity_received as the sum of received quantities.
     * @return int
     */
    public function getQuantityReceivedAttribute()
    {
        return $this->receiving_products()->sum('quantity');
    }

    /**
     * Return quantity_pending as the sum of pending quantities to be received.
     * @return [type] [description]
     */
    public function getQuantityPendingAttribute()
    {
        return $this->quantity - $this->quantity_received;
    }

    /**
     * Return is_completed if the product quantity order has been fully received or not.
     * @return boolean
     */
    public function getIsCompletedAttribute()
    {
        if ($this->quantity == $this->quantity_received) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Get the quantity_transferrable attribute
     * @return int
     */
    public function getQuantityTransferrableAttribute()
    {
        $quantity_transferrable = self::transfer_orders()->sum('quantity');

        return $this->quantity_received - $quantity_transferrable;
    }

    /**
     * WIP
     * Get the group_quantity_transferrable attribute
     * @return int As sum of quantity_transferrable on the product's group
     */
    public function getGroupQuantityTransferrableAttribute()
    {
        return 99;
    }

    /**
     * Get product groups and their aggregated informations such as the following
     * 
     * @return Collection
     * [
     * product_id,
     * name,
     * sku,
     * total_quantity_ordered,
     * total_quantity_received,
     * total_quantity_transferred,
     * total_quantity_transferrable
     * ]
     */
    public static function getGroups()
    {
        $groups = PurchaseOrderProduct::with(['receivings', 'transfer_orders', 'inventory', 'inventory.sku'])
            ->get()
            ->groupBy('product_id')
            ->map(function ($product_group) {
                $product_group->product_id              = $product_group->first()->product_id;
                $product_group->name                    = $product_group->first()->inventory->name;
                $product_group->sku                     = $product_group->first()->inventory->sku->code;
                $product_group->total_quantity_ordered  = $product_group->sum('quantity');
                $product_group->total_quantity_received = $product_group->sum(function ($product) {
                    return $product->receivings->sum('quantity');
                });
                $product_group->total_quantity_transferred = $product_group->sum(function ($product) {
                    return $product->transfer_orders->sum('quantity');
                });
                $product_group->total_quantity_transferrable = $product_group->total_quantity_received - $product_group->total_quantity_transferred;

                return $product_group;
            });

        return $groups;

        /**
         * WIP
         * Using SQL query only.
         *
         * ISSUES:
         * Redundant records on joins
         * Determine proper join to use
         */
        // Processing on DB
        // $products = PurchaseOrderProduct::join('purchase_order_receiving_products', 'purchase_order_products.id', '=', 'purchase_order_receiving_products.purchase_order_product_id')
        //     // ->join('transfer_orders', 'purchase_order_products.id', '=', 'transfer_orders.purchase_order_product_id')
        //     ->leftJoin('transfer_orders', 'purchase_order_products.id', '=', 'transfer_orders.purchase_order_product_id')
        //     ->join('inventories', 'purchase_order_products.product_id', '=', 'inventories.id')
        //     ->selectRaw('
        //         `product_id`,
        //         inventories.name AS `name`,
        //         COUNT(*) AS `product_group_count`,
        //         SUM(purchase_order_products.quantity) AS `total_quantity_ordered`,
        //         SUM(purchase_order_receiving_products.quantity) AS `total_quantity_received`,
        //         IFNULL(SUM(transfer_orders.quantity), 0) AS `total_quantity_transferred`,
        //         SUM(purchase_order_receiving_products.quantity) - IFNULL(SUM(transfer_orders.quantity), 0) AS total_quantity_transferrable
        //     ')
        //     ->having('total_quantity_transferrable', '>', 0)
        //     ->groupBy('product_id')
        //     ->orderBy('name')
        //     ->get();
    }
}
