<?php
namespace EG\Base\Facades;

use EG\Base\Helpers\BaseHelper;
use Illuminate\Support\Facades\Facade;

class BaseHelperFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return BaseHelper::class;
    }
}
