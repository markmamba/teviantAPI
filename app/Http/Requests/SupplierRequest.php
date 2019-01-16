<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SupplierRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'name'          => 'required|unique:suppliers,name|min:2|max:255',
            'address'       => 'nullable|min:2|max:255',
            'postal_code'   => 'nullable|min:2|max:255|min:2|max:255',
            'zip_code'      => 'nullable|min:2|max:255',
            'region'        => 'nullable|min:2|max:255',
            'city'          => 'nullable|min:2|max:255',
            'contact_title' => 'nullable|min:2|max:255',
            'contact_name'  => 'nullable|min:2|max:255',
            'contact_phone' => 'nullable|min:2|max:255',
            'contact_fax'   => 'nullable|min:2|max:255',
            'contact_email' => 'nullable|email|max:255',
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
