<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EcommerceRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
