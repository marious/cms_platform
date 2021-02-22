<?php
namespace EG\ACL\Repositories\Caches;

use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
