<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderPackageRequest extends FormRequest
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
            'order_id'             => 'required|exists:orders,id',
            'sales_invoice_number' => 'required|unique:order_packages,sales_invoice_number',
            'tracking_number'      => 'required|unique:order_packages,tracking_number',
        ];
    }
}
