<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MediaImageField extends FormField
{
    protected function getTemplate()
    {
        return 'core/base::forms.fields.media-image';
    }
}
