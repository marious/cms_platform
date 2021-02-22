<?php
namespace EG\Blog\Http\Requests;

use EG\Base\Supports\Language;
use Illuminate\Validation\Rule;
use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;

class TagRequest extends Request
{
  public function rules()
  {
      return [
          'name'        => 'required|max:120',
          'description' => 'max:400',
          'status'      => Rule::in(BaseStatusEnum::values()),
      ];
  }
}
