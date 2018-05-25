<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransferOrderRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Set the maximum transferable product quantity.
        $purchase_order_receiving_product = null;
        if (isset($this->purchase_order_receiving_product_id))
            $purchase_order_receiving_product = \App\Models\PurchaseOrderReceivingProduct::findOrFail($this->purchase_order_receiving_product_id)->product;
        // 2147483647 is just the maximum value INT of in MYSQL.
        $max_quantity = isset($purchase_order_receiving_product->quantity_pending) ? $purchase_order_receiving_product->quantity_pending : 2147483647;

        return [
            // 'name' => 'required|min:5|max:255'
            'purchase_order_receiving_product_id' => 'required|exists:purchase_order_products,id',
            'location_id'                         => 'required|exists:locations,id',
            'ailse'                               => 'nullable|max:255',
            'row'                                 => 'nullable|max:255',
            'bin'                                 => 'nullable|max:255',
            'quantity'                            => 'required|numeric|max:'.$max_quantity.'|min:1',
            'remark'                              => 'nullable|max:255',
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
            'purchase_order_receiving_product_id.required' => 'The product field is required.'
        ];
    }
}
