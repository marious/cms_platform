<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class UpdateSettingsRequest extends Request
{
    public function rules()
    {
        return [
            'store_name'    => 'required',
            'store_address' => 'required',
            'store_phone'   => 'required',
            'store_state'   => 'required',
            'store_city'    => 'required',
        ];
    }
}
