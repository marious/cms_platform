<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class ProductAttribute extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_product_attributes';

    protected $fillable = [
        'title',
        'slug',
        'color',
        'status',
        'order',
        'attribute_set_id',
        'image',
        'is_default',
    ];

    public $translatable = ['title'];



    protected $casts = [
        'status'    => BaseStatusEnum::class,
    ];

    public function getAttributeSetIdAttribute($value)
    {
        return (int)$value;
    }


    public function getGroupIdAttribute($value)
    {
        return (int)$value;
    }
}
