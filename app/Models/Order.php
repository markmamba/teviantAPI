<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Order extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    //protected $table = 'orders';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['status_id', 'packer_id', 'packed_at'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
   
    /**
     * Return true if the order has sufficient reservations else return false.
     * @return boolean
     */
    public function isSufficient()
    {
        if ($this->products->sum('quantity') == $this->reservations->sum('quantity_reserved'))
            return true;
        else
            return false;
    }

    /**
     * Reserve a given order's products.
     * TODO: This was copied with minor modifications from the OrderCrudController.
     * Should use this instead for reusability or maybe use Repositories.
     * 
     * @param  App\Models\Order  $order The model instance or the id of the model
     * @param  boolean $auto_pick_list Auto-set the status of the order to "Pick Listed"
     * if the order has reserved enough stocks.
     * @return Collection of App\Models\OrderProductReservation
     */
    public static function reserve(Order $order, $auto_pick_list = true)
    {
        foreach ($order->products as $product) {
            $reservations = self::reserveProduct($product);
        }

        if ($auto_pick_list && $order->isSufficient()) {
            $order->status_id = \App\Models\OrderStatus::where('name', 'Pick Listed')->first()->id;
            $order->save();
        }

        return $order->reservations;
    }

    /**
     * Reserve and or take available stock from the inventory.
     * @return  Collection of App\Models\OrderProductReservation
     */
    public static function reserveProduct(OrderProduct $order_product)
    {
        // Get items' stocks from all locations order by stock with most stock.
        $item = Inventory::findBySku2($order_product->sku);
        $stocks = $item->stocks()->orderBy('quantity', 'desc')->get();
        
        if (!$item->isInStock($order_product->quantity)) {
            // TODO: Record this deficiency so the admins know what to replenish
        }

        // Check if we can reserve enough stock from the most abundant location.
        if ($stocks->first()->hasEnoughStockForReservation($order_product->quantity)) {
            // Reserve the available stock.
            // $stocks->first()->take($order_product->quantity);

            // Save the product's reservation.
            $reservation                    = new OrderProductReservation();
            $reservation->order_product_id  = $order_product->id;
            $reservation->user_id           = \Auth::user()->id;
            $reservation->stock_id          = $stocks->first()->id;
            $reservation->quantity_reserved += $order_product->quantity;
            $reservation->save();

            // // tmp debug
            // echo '<hr>';
            // echo 'Stock #: '.$stocks->first()->id;
            // echo '<br>';
            // echo 'Order quantity: '.$order_product->quantity;
            // echo '<br>';
            // echo 'Stock quantity: '.$stocks->first()->quantity;
            // echo '<br>';
            // echo 'Reservable: '.$stocks->first()->quantityReservable();
            // echo '<br>';
            // echo 'Total reserved: '.$order_product->quantity_reserved;
            // echo '<br>';
            // echo 'Reserved: '.$reservation->quantity_reserved;
            // echo '<br>';
            // echo 'Fully reserved?: '.$order_product->isFullyReserved();
        } else {
            
            // // tmp debug
            // echo '<br>';
            // echo 'Order #: '.$order_product->order->id;

            foreach ($stocks as $key => $stock) {
                
                if ($stock->hasEnoughStockForReservation() && !$order_product->isFullyReserved()) {

                    // // tmp debug
                    // echo '<hr>';
                    // echo 'Stock #: '.$stock->id;
                    // echo '<br>';
                    // echo 'Order quantity: '.$order_product->quantity;
                    // echo '<br>';
                    // echo 'Stock quantity: '.$stock->quantity;
                    // echo '<br>';
                    // echo 'Reservable: '.$stock->quantityReservable();
                    // echo '<br>';
                    // echo 'Total reserved: '.$order_product->quantity_reserved;

                    // Formula: (order - (order - stock)) - reserved
                    // $stock_quantity_takable = ($order_product->quantity - ($order_product->quantity - $stock->quantity)) - $order_product->quantity_reserved;
                    // $stock->take($stock_quantity_takable);

                    $formula_result = $order_product->quantity - ($order_product->quantity - $stock->quantityReservable()) - $order_product->quantity_reserved;
                    // if ($formula_result <= 0) {
                    if ($formula_result <= $order_product->quantity && $formula_result >= 0) {
                        $stock_quantity_reservable = $order_product->quantity - ($order_product->quantity - $stock->quantityReservable()) - $order_product->quantity_reserved;
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Reservable formula: '. $order_product->quantity .'-('.$order_product->quantity .'-'. $stock->quantityReservable().')-'. $order_product->quantity_reserved;
                    }
                    else {
                        $stock_quantity_reservable = $order_product->quantity - $order_product->quantity_reserved;
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Reservable formula used: '. $order_product->quantity .'-'. $order_product->quantity_reserved;
                    }

                    // // tmp
                    // echo '<br>';
                    // echo '$stock_quantity_reservable: '.$stock_quantity_reservable;

                    try {
                        // Save the product's reservation.
                        $reservation                    = new OrderProductReservation();
                        $reservation->order_product_id  = $order_product->id;
                        $reservation->user_id           = \Auth::user()->id;
                        $reservation->stock_id          = $stock->id;
                        $reservation->quantity_reserved += $stock_quantity_reservable;
                        $reservation->save();
                    } catch (\Exception $e) {
                        abort(500, $e->getMessage());
                        // // tmp debug
                        // echo '<br>';
                        // echo 'Error on iteration: '.$key;
                    }

                    // // tmp debug
                    // echo '<br>';
                    // echo 'Reserved: '.$reservation->quantity_reserved;
                    // echo '<br>';
                    // echo 'Fully reserved?: '.$order_product->isFullyReserved();
                } else {
                    break;
                }
            }
        }

        return $order_product->reservations();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
   
    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function shipment()
    {
        return $this->hasOne('App\Models\OrderShipment', 'order_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne('App\Models\OrderShippingAddress');
    }

    public function billingAddress()
    {
        return $this->hasOne('App\Models\OrderBillingAddress');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status_id');
    }

    public function reservations()
    {
        return $this->hasManyThrough('App\Models\OrderProductReservation', 'App\Models\OrderProduct', 'order_id', 'order_product_id');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\OrderCarrier', 'order_id');
    }

    public function packer()
    {
        return $this->belongsTo('App\User', 'packer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
   
    /**
     * Scope orders to only include records that are not marked as Done.
     * @param  $query Illuminate\Database\Eloquent\Builder
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncomplete($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->whereNotIn('name', ['Done', 'Cancelled']);
        });
    }

    public function scopePending($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Pending');
        });
    }

    public function scopeForPicking($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Pick Listed');
        });
    }

    public function scopeForShipping($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Packed');
        });
    }

    public function scopeShipped($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Shipped');
        });
    }

    public function scopeDone($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Done');
        });
    }

    public function scopeCompleted($query)
    {
        return $this->scopeDone($query);
    }

    public function scopeCancelled($query)
    {
        return $query->whereHas('status', function ($query) {
            $query->where('name', 'Cancelled');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
   
    public function getProductsCountAttribute()
    {
        return $this->products->count();
    }

    public function getFullUserNameAttribute()
    {
        return $this->shippingAddress->name;
    }

    public function getFullShippingAddressAttribute()
    {
        return $this->shippingAddress->address1 . ', ' . $this->shippingAddress->address1 . ', ' . $this->shippingAddress->city . ', ' . $this->shippingAddress->county . ', ' . $this->shippingAddress->postal_code;
    }

    public function getFullBillingAddressAttribute()
    {
        return $this->billingAddress->address1 . ', ' . $this->billingAddress->address1 . ', ' . $this->billingAddress->city . ', ' . $this->billingAddress->county . ', ' . $this->billingAddress->postal_code;
    }

    public function getTotalAttribute()
    {
        return $this->products->sum('price');
    }

    public function getDeficiencyAttribute()
    {
        return $this->products->sum('quantity') - $this->reservations->sum('quantity_reserved');
    }
}
