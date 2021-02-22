<?php

namespace EG\Ecommerce\Models;

use EG\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProductVariationItem extends BaseModel
{
    use HasTranslations;

    protected $table = 'ec_product_variation_items';

    public $translatable = ['title', 'attribute_set_title', 'attribute_set_slug'];

    protected $fillable = [
        'attribute_id',
        'variation_id',
    ];

    public $timestamps = false;


    public function productVariation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id')->withDefault();
    }

    public function attributes(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id')->withDefault();
    }
}
