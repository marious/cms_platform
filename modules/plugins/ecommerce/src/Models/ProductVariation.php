<?php

namespace EG\Ecommerce\Models;

use EG\Base\Events\DeletedContentEvent;
use EG\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariation extends BaseModel
{
    protected $table = 'ec_product_variations';

    protected $fillable = [
        'product_id',
        'configurable_product_id',
        'is_default',
    ];

    public $timestamps = false;

    public function variationItems(): HasMany
    {
        return $this->hasMany(ProductVariationItem::class, 'variation_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function configurableProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'configurable_product_id')->withDefault();
    }

    public function productAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductAttribute::class, 'ec_product_variation_items', 'variation_id', 'attribute_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleted(function (ProductVariation $variation) {
            $variation->productAttributes()->detach();

            $product = Product::find($variation->product_id);
            if ($product) {
                $product->delete();
                event(new DeletedContentEvent(PRODUCT_MODULE_SCREEN_NAME, request(), $product));
            }
        });
    }
}
