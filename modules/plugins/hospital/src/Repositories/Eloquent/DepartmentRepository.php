<?php
namespace EG\Hospital\Repositories\Eloquent;

use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;

class DepartmentRepository extends RepositoriesAbstract implements DepartmentInterface
{
    public function getAllDepartments(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);
        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllDepartmentsForSelect(array $condition = [], array $with = [], array $select = ['*'])
    {
        $departments = $this->getAllDepartments($condition, $with, $select);
        $returned = [];
        if ($departments && count($departments)) {
            $returned[] = trans('plugins/hospital::department.form.select_department');
            foreach ($departments as $department) {
                $returned[$department->id] = $department->name;
            }
        }
        return $returned;
    }
}
