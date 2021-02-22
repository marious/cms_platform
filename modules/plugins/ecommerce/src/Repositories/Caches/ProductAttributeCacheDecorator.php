<?php

namespace EG\Ecommerce\Repositories\Caches;

use EG\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class ProductAttributeCacheDecorator extends CacheAbstractDecorator implements ProductAttributeInterface
{


    public function getAllWithSelected($productId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
