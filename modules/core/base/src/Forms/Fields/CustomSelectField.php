<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class CustomSelectField extends SelectType
{
    protected function getTemplate()
    {
        return 'core/base::forms.fields.custom-select';
    }
}
