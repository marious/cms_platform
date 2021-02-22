<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MultiCheckListField extends FormField
{

    protected function getTemplate()
    {
        return 'core/base::forms.fields.multi-check-list';
    }
}
