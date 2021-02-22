<?php

namespace EG\Base\Forms\Fields;

use Assets2;
use Kris\LaravelFormBuilder\Fields\FormField;

class MediaImagesField extends FormField
{

    protected function getTemplate()
    {
        Assets2::addScripts(['jquery-ui']);

        return 'core/base::forms.fields.media-images';
    }
}
