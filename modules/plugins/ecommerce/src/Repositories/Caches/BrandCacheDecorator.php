<?php

namespace EG\Ecommerce\Repositories\Caches;

use EG\Ecommerce\Repositories\Interfaces\BrandInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class BrandCacheDecorator extends CacheAbstractDecorator implements BrandInterface
{

    public function getAll(array $condition = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
