<?php
namespace Theme\Pearl\Http\Controllers;

use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Theme\Http\Controllers\PublicController;

class ThemePearlController extends PublicController
{
    public function getIndex(BaseHttpResponse $response)
    {
        return Parent::getIndex($response);
    }
}
