<?php

namespace EG\Ecommerce\Facades;

use EG\Ecommerce\Supports\CurrencySupport;
use Illuminate\Support\Facades\Facade;

class CurrencyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CurrencySupport::class;
    }
}
