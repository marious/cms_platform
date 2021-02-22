<?php

namespace EG\Ecommerce\Repositories\Eloquent;

use EG\Ecommerce\Repositories\Interfaces\BrandInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;

class BrandRepository extends RepositoriesAbstract implements BrandInterface
{

    public function getAll(array $condition = [])
    {
        $data = $this->model
                    ->where($condition)
                    ->orderBy('is_featured', 'DESC')
                    ->orderBy('name', 'DESC')
                    ->get();
        $this->resetModel();

        return $data;
    }
}
