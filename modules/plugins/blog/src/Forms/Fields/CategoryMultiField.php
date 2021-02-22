<?php
namespace EG\Blog\Forms\Fields;
use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{
    protected function getTemplate()
    {
        return 'plugins/blog::categories.categories-multi';
    }
}
