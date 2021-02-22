<?php

namespace EG\Ecommerce\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface GroupedProductInterface extends RepositoryInterface
{
    /**
     * @param int $groupedProductId
     * @param array $params
     * @return mixed
     */
    public function getChildren($groupedProductId, array $params);

    /**
     * @param int $groupedProductId
     * @param array $childItems
     * @return mixed
     */
    public function createGroupedProducts($groupedProductId, array $childItems);
}
