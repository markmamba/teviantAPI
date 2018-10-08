<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;

class ProductsController extends Controller
{
    public function store(InventoryRequest $request)
    {
    	// Authenticate a default user for identification.
    	$credentials = [
    		'email'    => 'super_user@teviant.com',
    		'password' => null !== env('DEFAULT_ADMIN_PASSWORD') ? env('DEFAULT_ADMIN_PASSWORD') : 'password',
    	];

    	if (!\Auth::once($credentials))
		    throw new \Exception('Invalid credentials.');

		return Inventory::create(collect($request->all())->merge(['user_id' => 1])->toArray())->updateSku($request->sku_code);
    }
}
