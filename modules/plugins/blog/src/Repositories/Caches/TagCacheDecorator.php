<?php

namespace EG\Blog\Repositories\Caches;

use EG\Support\Repositories\Caches\CacheAbstractDecorator;
use EG\Blog\Repositories\Interfaces\TagInterface;

class TagCacheDecorator extends CacheAbstractDecorator implements TagInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularTags($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllTags($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
