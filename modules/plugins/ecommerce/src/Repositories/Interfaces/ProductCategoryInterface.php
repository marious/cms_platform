<?php

namespace EG\Ecommerce\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface ProductCategoryInterface extends RepositoryInterface
{
    /**
     * get categories filter by $param
     *
     * $param['active'] => [true,false]
     * $param['order_by'] => [ASC, DESC]
     * $param['is_child'] => [true,false, null]
     * $param['is_feature'] => [true,false, null]
     * $param['num'] => [int,null]
     * @return Collection categories model
     */
    public function getCategories(array $param);

    public function getDataSiteMap();

    public function getFeaturedCategories($limit);

    public function getAllCategories($active = true);
}
