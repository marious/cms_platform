<?php
namespace EG\ACL\Http\Requests;

use EG\Support\Http\Requests\Request;

class RoleCreateRequest extends Request
{
    public function rules()
    {
        return [
            'name'        => 'required|max:60|min:3',
            'description' => 'required|max:255',
        ];
    }
}
