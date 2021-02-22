<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CustomerCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:120|min:2',
            'email'                 => 'required|max:60|min:6|email|unique:ec_customers',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
