<?php

namespace EG\Hospital\Repositories\Caches;

use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class DepartmentCacheDecorator extends CacheAbstractDecorator implements DepartmentInterface
{
    public function getAllDepartments(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function getAllDepartmentsForSelect(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
