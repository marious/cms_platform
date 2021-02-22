<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Assets2;

class ColorField extends FormField
{
    protected function getTemplate()
    {
        Assets2::addScripts(['colorpicker'])->addStyles(['colorpicker']);
        return 'core/base::forms.fields.color';
    }
}
