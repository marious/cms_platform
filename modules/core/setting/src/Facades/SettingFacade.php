<?php
namespace EG\Setting\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Setting\Supports\SettingStore;

class SettingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingStore::class;
    }
}
