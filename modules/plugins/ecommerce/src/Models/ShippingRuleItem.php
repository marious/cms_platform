<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;

class ShippingRuleItem extends BaseModel
{
    protected $table = 'ec_shipping_rule_items';

    protected $fillable = [
        'shipping_rule_id',
        'city',
        'adjustment_price',
        'is_enabled',
    ];

    public function setAdjustmentPriceAttribute($value)
    {
        $this->attributes['adjustment_price'] = (float)str_replace(',', '', $value);
    }

    public function getAdjustmentPriceAttribute()
    {
        return number_format($this->attributes['adjustment_price'], 0, false, false);
    }
}
