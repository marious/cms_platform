<?php
namespace EG\Base\Facades;


use EG\Base\Supports\PageTitle;
use Illuminate\Support\Facades\Facade;

class PageTitleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PageTitle::class;
    }
}
