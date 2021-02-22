<?php

namespace EG\Base\Forms\Fields;

use Arr;
use Assets2;
use Kris\LaravelFormBuilder\Fields\FormField;

class EditorField extends FormField
{

    protected function getTemplate()
    {
        Assets2::addScriptsDirectly('vendor/core/base/js/editor.js');
        return 'core/base::forms.fields.editor';
    }

    /**
     *{@inheritDoc}
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['with-short-code'] = Arr::get($options, 'with-short-code', false);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
