<?php

return [
    [
        'name' => 'E-commerce',
        'flag' => 'plugins.ecommerce',
    ],

    // Customers
    [
        'name'          => 'Customers',
        'flag'          => 'customers.index',
        'parent_flag'   => 'plugins.ecommerce',
    ],
    [
        'name'          => 'Create',
        'flag'          => 'customers.create',
        'parent_flag'   => 'plugins.ecommerce',
    ],
    [
        'name'          => 'Edit',
        'flag'          => 'customers.edit',
        'parent_flag'   => 'plugins.ecommerce',
    ],
    [
        'name'          => 'Delete',
        'flag'          => 'customers.destroy',
        'parent_flag'   => 'plugins.ecommerce',
    ],
];
