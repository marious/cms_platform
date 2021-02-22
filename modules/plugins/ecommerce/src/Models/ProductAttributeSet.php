<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Spatie\Translatable\HasTranslations;

class ProductAttributeSet extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_product_attribute_sets';

    protected $fillable = [
        'title',
        'status',
        'order',
        'display_layout',
        'is_searchable',
        'is_comparable',
        'is_use_in_product_listing',
    ];

    public $translatable = ['title', 'slug'];

    protected $casts = [
        'status'    => BaseStatusEnum::class,
    ];

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_set_id')
                    ->orderBy('order', 'ASC');
    }
}
