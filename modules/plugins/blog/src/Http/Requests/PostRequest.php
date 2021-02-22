<?php

namespace EG\Blog\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use EG\Blog\Supports\PostFormat;

class PostRequest extends Request
{
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'description' => 'max:400',
            'categories'  => 'required',
            'format_type' => Rule::in(array_keys(PostFormat::getPostFormats(true))),
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
