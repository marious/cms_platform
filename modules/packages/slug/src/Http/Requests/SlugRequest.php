<?php

namespace EG\Slug\Http\Requests;

use EG\Support\Http\Requests\Request;

class SlugRequest extends Request
{
    public function rules()
    {
        return [
            'name'    => 'required',
            'slug_id' => 'required',
        ];
    }
}
