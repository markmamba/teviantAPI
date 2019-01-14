<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipOrderRequest extends FormRequest
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
            'package_length' => 'nullable|numeric|min:0',
            'package_width'  => 'nullable|numeric|min:0',
            'package_height' => 'nullable|numeric|min:0',
            'package_weight' => 'nullable|numeric|min:0',
        ];
    }
}
