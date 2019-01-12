<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InventoryStockRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'inventory_id' => 'required',
            'location_id'  => 'required',
            'quantity'     => 'required|numeric|min:0',
            'cost'         => 'nullable|numeric|min:0',
            'reason'       => 'nullable|min:2|max:255',
            'aisle'        => 'nullable|max:255',
            'row'          => 'nullable|max:255',
            'bin'          => 'nullable|max:255',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
