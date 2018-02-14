<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplenishStockRequest extends FormRequest
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
        return [
            'location_id'  => 'required',
            'new_quantity' => 'required|numeric|min:1',
            'cost'         => 'nullable|numeric|min:0',
            'string'       => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'new_quantity' => 'The :attribute must be at least :value',
        ];
    }
}
