<?php
return [
    [
        'name'  => 'Hospital',
        'flag'  => 'plugins.hospital',
    ],
    [
        'name'          => 'Departments',
        'flag'          => 'departments.index',
        'parent_flag'   => 'plugins.hospital',
    ],
    [
        'name'          => 'Create',
        'flag'          => 'departments.create',
        'parent_flag'   => 'departments.index',
    ],
    [
        'name'          => 'Edit',
        'flag'          => 'departments.edit',
        'parent_flag'   => 'departments.index',
    ],
    [
        'name'          => 'Delete',
        'flag'          => 'departments.destroy',
        'parent_flag'   => 'departments.index',
    ],
    [
        'name'          => 'Doctors',
        'flag'          => 'doctors.index',
        'parent_flag'   => 'plugins.hospital',
    ],
    [
        'name'          => 'Create',
        'flag'          => 'doctors.create',
        'parent_flag'   => 'doctors.index',
    ],
    [
        'name'          => 'Edit',
        'flag'          => 'doctors.edit',
        'parent_flag'   => 'doctors.index',
    ],
    [
        'name'          => 'Delete',
        'flag'          => 'doctors.destroy',
        'parent_flag'   => 'doctors.index',
    ],
];
