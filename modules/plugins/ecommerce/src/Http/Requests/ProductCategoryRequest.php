<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class ProductCategoryRequest extends Request
{

    public function rules()
    {
        return [
            'name'  => 'required',
            'order' => 'required|integer|min:0',
        ];
    }
}
