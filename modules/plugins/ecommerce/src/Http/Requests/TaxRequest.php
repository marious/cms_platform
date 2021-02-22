<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class TaxRequest extends Request
{
    public function rules()
    {
        return [
            'title'      => 'required|max:255',
            'percentage' => 'required|between:0,99.99',
            'priority'   => 'required|min:0',
        ];
    }
}
