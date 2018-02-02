<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Inventory\Traits\InventorySkuTrait;

class InventorySku extends Model
{
    use InventorySkuTrait;

    protected $table = 'inventory_skus';
    
    protected $fillable = array(
        'inventory_id',
        'code',
    );
    
    public function item()
    {
        return $this->belongsTo('Inventory', 'inventory_id', 'id');
    }
}
