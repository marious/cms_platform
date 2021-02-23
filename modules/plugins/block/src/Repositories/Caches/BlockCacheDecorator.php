<?php

namespace EG\Block\Repositories\Caches;

use EG\Support\Repositories\Caches\CacheAbstractDecorator;
use EG\Block\Repositories\Interfaces\BlockInterface;

class BlockCacheDecorator extends CacheAbstractDecorator implements BlockInterface
{
    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
