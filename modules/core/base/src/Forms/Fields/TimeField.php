<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Assets2;

class TimeField extends FormField
{
    protected function getTemplate()
    {
        Assets2::addScripts(['timepicker'])
            ->addStyles(['timepicker']);

        return 'core/base::forms.fields.time';
    }
}
