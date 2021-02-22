<?php
namespace EG\Ecommerce\Facades;

use EG\Ecommerce\Supports\EcommerceHelper;
use Illuminate\Support\Facades\Facade;

class EcommerceHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return EcommerceHelper::class;
    }
}
