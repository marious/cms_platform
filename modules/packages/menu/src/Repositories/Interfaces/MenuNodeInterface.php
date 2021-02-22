<?php

namespace EG\Menu\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface MenuNodeInterface extends RepositoryInterface
{
    /**
     * @param int $menuId
     * @param int $parentId
     * @param array $select
     * @param array $with
     * @return array|Collection|static[]
     */
    public function getByMenuId($menuId, $parentId, $select = ['*'], array $with = ['child', 'reference', 'reference.slugable']);
}
