<?php

namespace EG\Contact\Http\Requests;

use EG\Support\Http\Requests\Request;

class ContactReplyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required',
        ];
    }
}
