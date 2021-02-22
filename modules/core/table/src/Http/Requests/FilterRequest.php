<?php
namespace EG\Table\Http\Requests;

use EG\Support\Http\Requests\Request;

class FilterRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'class' => 'required',
        ];
    }
}
