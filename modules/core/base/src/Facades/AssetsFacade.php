<?php
namespace EG\Base\Facades;

use EG\Base\Supports\Assets;
use Illuminate\Support\Facades\Facade;

class AssetsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
