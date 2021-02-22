<?php

namespace EG\Widget\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Widget\WidgetGroup;

class WidgetFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'packages.widget';
    }

    /**
     * Get the widget group object.
     *
     * @param string $name
     *
     * @return WidgetGroup
     */
    public static function group($name)
    {
        return app('packages.widget-group-collection')->group($name);
    }
}
