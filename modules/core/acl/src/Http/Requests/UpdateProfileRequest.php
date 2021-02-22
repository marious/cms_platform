<?php
namespace EG\ACL\Http\Requests;

use EG\Support\Http\Requests\Request;
use Auth;

class UpdateProfileRequest extends Request
{
    public function rules()
    {
        return [
            'username'   => 'required|max:30|min:4',
            'first_name' => 'required|max:60|min:2',
            'last_name'  => 'required|max:60|min:2',
            'email'      => 'required|max:60|min:6|email',
        ];
    }
}
