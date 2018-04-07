<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceiving extends Model
{
    use CrudTrait;

    public function product()
    {
        return $this->belongsTo('App\Models\PurchaseOrderProduct');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }
}
