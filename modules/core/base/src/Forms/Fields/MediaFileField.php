<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MediaFileField extends FormField
{
    protected function getTemplate()
    {
        return 'core/base::forms.fields.media-file';
    }
}
