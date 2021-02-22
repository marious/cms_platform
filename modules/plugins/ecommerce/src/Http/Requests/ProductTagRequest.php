<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductTagRequest extends Request
{
    public function rules()
    {
        return [
            'name'      => 'required',
            'status'    => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
