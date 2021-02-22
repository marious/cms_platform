<?php

namespace EG\Base\Facades;

use EG\Base\Supports\EmailHandler;
use Illuminate\Support\Facades\Facade;

class EmailHandlerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return EmailHandler::class;
    }
}
