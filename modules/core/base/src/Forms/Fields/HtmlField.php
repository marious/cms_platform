<?php

namespace EG\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class HtmlField extends FormField
{
    protected function getDefaults()
    {
        return [
            'html'          => '',
            'wrapper'       => false,
            'label_show'    => false,
        ];
    }

    public function getAllAttributes()
    {
        return [];
    }

    protected function getTemplate()
    {
        return 'core/base::forms.fields.html';
    }
}
