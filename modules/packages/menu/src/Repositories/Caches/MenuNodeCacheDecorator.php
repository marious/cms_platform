<?php

namespace EG\Menu\Repositories\Caches;

use EG\Support\Repositories\Caches\CacheAbstractDecorator;
use EG\Menu\Repositories\Interfaces\MenuNodeInterface;

class MenuNodeCacheDecorator extends CacheAbstractDecorator implements MenuNodeInterface
{
    public function getByMenuId($menuId, $parentId, $select = ['*'], array $with = ['child', 'reference', 'reference.slugable'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
