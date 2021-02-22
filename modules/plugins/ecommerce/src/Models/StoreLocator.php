<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;
use EG\Base\Supports\Helper;

class StoreLocator extends BaseModel
{
    protected $table = 'ec_store_locators';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'country',
        'state',
        'city',
        'is_primary',
        'is_shipping_location',
    ];

    public function getCountryNameAttribute()
    {
        return Helper::getCountryNameByCode($this->country);
    }
}
