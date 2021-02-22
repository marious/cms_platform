<?php

namespace EG\Ecommerce\Repositories\Eloquent;

use EG\Base\Enums\BaseStatusEnum;
use EG\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Collection;

class ProductCategoryRepository extends RepositoriesAbstract implements ProductCategoryInterface
{
    const TABLE_NAME = 'ec_product_categories';

    public function getCategories(array $param)
    {
        $param = array_merge([
            'active'        => true,
            'order_by'      => 'desc',
            'is_child'      => null,
            'is_featured'   => null,
            'num'           => null,
        ], $param);

        $data = $this->model->select(self::TABLE_NAME . '.*');

        if ($param['active']) {
            $data = $data->where(self::TABLE_NAME . '.status', BaseStatusEnum::PUBLISHED);
        }

        if ($param['is_child'] !== null) {
            if ($param['is_child'] === true) {
                $data = $data->where(self::TABLE_NAME . '.parent_id', '<>',0);
            } else {
                $data = $data->where(self::TABLE_NAME . '.parent_id', 0);
            }
        }

        if ($param['is_featured']) {
            $data = $data->where(self::TABLE_NAME . '.is_featured', $param['is_featured']);
        }

        $data = $data->orderBy(self::TABLE_NAME . '.order', $param['order_by']);

        if ($param['num'] !== null) {
            $data = $data->limit($param['num']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getDataSiteMap()
    {
        $data = $this->model
            ->where(self::TABLE_NAME . '.status', BaseStatusEnum::PUBLISHED)
            ->select(self::TABLE_NAME . '.*')
            ->orderBy(self::TABLE_NAME . '.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }


    public function getFeaturedCategories($limit)
    {
        $data = $this->model
            ->where([
                self::TABLE_NAME . '.status'      => BaseStatusEnum::PUBLISHED,
                self::TABLE_NAME . '.is_featured' => 1,
            ])
            ->select([
                self::TABLE_NAME . '.id',
                self::TABLE_NAME . '.name',
                self::TABLE_NAME . '.icon',
            ])
            ->orderBy(self::TABLE_NAME . '.order', 'asc')
            ->select(self::TABLE_NAME . '.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllCategories($active = true)
    {
        $data = $this->model->select(self::TABLE_NAME . '.*');
        if ($active) {
            $data = $data->where([self::TABLE_NAME . '.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
