<?php

namespace EG\Slug\Facades;

use Illuminate\Support\Facades\Facade;
use EG\Slug\SlugHelper;

class SlugHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SlugHelper::class;
    }
}
