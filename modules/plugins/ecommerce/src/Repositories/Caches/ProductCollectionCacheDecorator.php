<?php

namespace EG\Ecommerce\Repositories\Caches;

use EG\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class ProductCollectionCacheDecorator extends CacheAbstractDecorator implements ProductCollectionInterface
{

//    public function createSlug($name, $id)
//    {
//        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
//    }
}
