<?php
namespace EG\ACL\Http\Requests;

use EG\Support\Http\Requests\Request;

class AvatarRequest extends Request
{
    public function rules()
    {
        return [
          'avatar_file' => 'required|image|mimes:jpg,jpeg,png',
          'avatar_data' => 'required',
        ];
    }
}
