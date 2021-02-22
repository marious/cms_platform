<?php

namespace EG\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Theme\Supports\AdminBar;

class AdminBarFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminBar::class;
    }
}
