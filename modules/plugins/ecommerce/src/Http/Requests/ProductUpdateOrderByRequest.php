<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class ProductUpdateOrderByRequest extends Request
{
    public function rules()
    {
        return [
            'value' => 'required|numeric',
        ];
    }
}
