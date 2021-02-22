<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class StoreLocatorRequest extends Request
{
    public function rules()
    {
        return [
            'name'    => 'required|max:255',
            'email'   => 'email|nullable|max:60',
            'phone'   => 'required|numeric',
            'state'   => 'required|max:120',
            'city'    => 'required|max:120',
            'address' => 'required|max:120',
        ];
    }
}
