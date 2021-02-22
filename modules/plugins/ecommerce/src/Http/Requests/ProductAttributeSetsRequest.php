<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductAttributeSetsRequest extends Request
{
    public function rules()
    {
        return [
            'title'         => 'required|max:255',
//            'description'   => 'required|max:255',
            'order'         => 'required|integer|min:0|max:127',
            'status'        => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
