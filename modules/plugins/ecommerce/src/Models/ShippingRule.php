<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleItemInterface;

class ShippingRule extends BaseModel
{
    protected $table = 'ec_shipping_rules';

    protected $fillable = [
        'name',
        'price',
        'currency_id',
        'type',
        'from',
        'to',
        'shipping_id',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (ShippingRule $shippingRule) {
            app(ShippingRuleItemInterface::class)->deleteBy(['shipping_rule_id' => $shippingRule->id]);
        });
    }

    public function items()
    {
        return $this->hasMany(ShippingRuleItem::class, 'shipping_rule_id');
    }

}
