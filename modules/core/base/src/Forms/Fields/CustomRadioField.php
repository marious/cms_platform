<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CustomRadioField extends FormField
{
    protected function getTemplate()
    {
        return 'core/base::forms.fields.custom-radio';
    }
}
