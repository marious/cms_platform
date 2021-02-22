<?php
namespace EG\Translation\Http\Requests;
use EG\Support\Http\Requests\Request;

class TranslationRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
