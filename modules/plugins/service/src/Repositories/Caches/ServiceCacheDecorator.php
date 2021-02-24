<?php

namespace EG\Service\Repositories\Caches;

use EG\Support\Repositories\Caches\CacheAbstractDecorator;
use EG\Service\Repositories\Interfaces\ServiceInterface;

class ServiceCacheDecorator extends CacheAbstractDecorator implements ServiceInterface
{
	public function getAllServices($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
    public function getListServiceNonInList(array $selected = [], $limit = 6)
    {
    	return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
