<?php
namespace EG\Page\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Page\Supports\Template;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PageRequest extends Request
{
    public function rules()
    {
        return [
            'name'  => 'required|max:120',
            'content' => 'required',
            'template' => Rule::in(array_keys(Template::getPageTemplates())),
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
