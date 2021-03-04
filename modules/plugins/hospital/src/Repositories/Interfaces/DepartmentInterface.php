<?php

namespace EG\Hospital\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface DepartmentInterface extends RepositoryInterface
{
    public function getAllDepartments(array $condition = [], array $with = [], array $select = ['*']);

    public function getAllDepartmentsForSelect(array $condition = [], array $with = [], array $select = ['*']) ;
}
