<?php

return [
    [
        'name' => 'Services',
        'flag' => 'service.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'service.create',
        'parent_flag' => 'service.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'service.edit',
        'parent_flag' => 'service.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'service.destroy',
        'parent_flag' => 'service.index',
    ],
    [
        'name' => 'BusinessSolutions',
        'flag' => 'BusinessSolutions.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'BusinessSolutions.create',
        'parent_flag' => 'BusinessSolutions.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'BusinessSolutions.edit',
        'parent_flag' => 'BusinessSolutions.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'BusinessSolutions.destroy',
        'parent_flag' => 'BusinessSolutionss.index',
    ],
];
