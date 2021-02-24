<?php
namespace Theme\Leaders\Http\Controllers;

use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Theme\Http\Controllers\PublicController;

class LeaderThemeController extends PublicController
{
    public function getIndex(BaseHttpResponse $response)
    {
        return parent::getIndex($response);
    }
}
