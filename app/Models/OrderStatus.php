<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public function orders()
    {
    	return $this->hasMany('App\Models\Order', 'status_id');
    }
}
