<?php
namespace EG\Base\Facades;

use EG\Base\Supports\DashboardMenu;
use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DashboardMenu::class;
    }
}
