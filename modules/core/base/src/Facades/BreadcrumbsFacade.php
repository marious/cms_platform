<?php
namespace EG\Base\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Base\Supports\BreadcrumbsManager;

class BreadcrumbsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BreadcrumbsManager::class;
    }
}
