<?php

namespace EG\Ecommerce\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface BrandInterface extends RepositoryInterface
{
    public function getAll(array $condition = []);
}
