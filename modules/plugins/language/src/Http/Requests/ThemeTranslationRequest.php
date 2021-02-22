<?php

namespace EG\Language\Http\Requests;

use EG\Support\Http\Requests\Request;

class ThemeTranslationRequest extends Request
{
    public function handle()
    {
        return [
            'locale'       => 'required',
            'translations' => 'required|array',
        ];
    }
}
