<?php

namespace EG\Language\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Language\LanguageManager;

class LanguageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LanguageManager::class;
    }
}
