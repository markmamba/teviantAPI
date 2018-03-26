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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'package_length' => 'numeric|min:0',
            'package_width'  => 'numeric|min:0',
            'package_height' => 'numeric|min:0',
            'package_weight' => 'numeric|min:0',
        ];
    }
}
