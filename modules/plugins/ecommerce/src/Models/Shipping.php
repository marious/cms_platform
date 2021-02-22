<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleInterface;

class Shipping extends BaseModel
{
    protected $table = 'ec_shipping';

    protected $fillable = [
        'title',
        'country',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Shipping $shipping) {
            app(ShippingRuleInterface::class)->deleteBy(['shipping_id' => $shipping->id]);
        });
    }

    public function rules()
    {
        return $this->hasMany(ShippingRule::class, 'shipping_id');
    }
}
