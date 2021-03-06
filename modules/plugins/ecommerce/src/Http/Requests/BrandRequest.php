<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BrandRequest extends Request
{
    public function rules()
    {
        return [
            'name'   => 'required',
//            'slug'   => 'required',
            'order'  => 'required|integer|min:0|max:127',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
