<?php
namespace EG\Translation\Http\Requests;
use EG\Support\Http\Requests\Request;

class LocaleRequest extends Request
{
    public function rules()
    {
        return [
            'locale' => 'required',
        ];
    }
}
