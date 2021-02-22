<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;

class GroupedProduct extends BaseModel
{
    protected $table = 'ec_grouped_products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_product_id',
        'product_id',
        'fixed_qty',
    ];

    public $timestamps = false;
}
