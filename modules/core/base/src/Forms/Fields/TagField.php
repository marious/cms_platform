<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Assets2;

class TagField extends FormField
{
    protected function getTemplate()
    {
        Assets2::addStylesDirectly('vendor/core/base/libraries/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/core/base/libraries/tagify/tagify.js',
                'vendor/core/base/js/tags.js',
            ]);

        return 'core/base::forms.fields.tags';
    }
}
