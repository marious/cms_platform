<?php
namespace EG\SimpleSlider\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SimpleSliderRequest extends Request
{
    public function rules()
    {
        return [
            'name'   => 'required',
            'key'    => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
