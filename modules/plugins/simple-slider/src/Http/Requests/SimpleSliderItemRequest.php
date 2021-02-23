<?php

namespace EG\SimpleSlider\Http\Requests;

use EG\Support\Http\Requests\Request;

class SimpleSliderItemRequest extends Request
{
    public function rules()
    {
        return [
            'simple_slider_id' => 'required',
            'title'            => 'max:255',
            'image'            => 'required',
            'order'            => 'required|integer|min:0|max:1000',
        ];
    }
}
