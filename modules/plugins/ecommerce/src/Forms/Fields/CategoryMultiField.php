<?php
namespace EG\Ecommerce\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{

    protected function getTemplate()
    {
        return 'plugins/ecommerce::product-categories.partials.categories-multi';
    }
}
