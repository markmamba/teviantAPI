<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InventoryRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'metric_id'   => 'required',
            'category_id' => 'required',
            'name'        => 'required|min:2|max:255|unique:inventories,name,' . $this->route('inventory'),
            'sku_code'    => 'required|min:2|max:255|unique:inventory_skus,code,' . $this->route('inventory'),
            'description' => 'nullable|min:2|max:255',
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
