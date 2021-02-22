<?php

namespace EG\Slug\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;
use Assets2;

class PermalinkField extends FormField
{

    protected function getTemplate()
    {
        Assets2::addScriptsDirectly('vendor/core/packages/slug/js/slug.js')
            ->addStylesDirectly('vendor/core/packages/slug/css/slug.css');

        return 'packages/slug::forms.fields.permalink';
    }
}
