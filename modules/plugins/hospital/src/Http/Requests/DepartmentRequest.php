<?php

namespace EG\Hospital\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DepartmentRequest extends Request
{
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
            'description'   => 'max:400',
            'status'        => Rule::in(BaseStatusEnum::values()),

        ];
    }
}
