<?php

use EG\Base\Enums\BaseStatusEnum;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;

if (!function_exists('get_departments')) {



    function get_departments($withSelectedLabel = true) {
        $data = app(DepartmentInterface::class)->getAllDepartmentsForSelect(
            ['status'    => BaseStatusEnum::PUBLISHED],
            [],
            ['id', 'name']
        );
        if ($withSelectedLabel == false) {
           $data = array_slice($data, 1, null, true);
        }
        return $data;
    }
}
