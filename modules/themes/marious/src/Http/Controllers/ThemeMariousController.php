<?php
namespace Theme\Marious\Http\Controllers;

use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Theme\Http\Controllers\PublicController;
use Theme;

class ThemeMariousController extends PublicController
{
    public function getIndex(BaseHttpResponse $response)
    {
        return Parent::getIndex($response);
    }
}
