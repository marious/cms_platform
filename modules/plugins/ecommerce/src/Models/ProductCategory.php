<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_product_categories';

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'order',
        'status',
        'image',
        'is_featured',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_product_category_product', 'category_id', 'product_id')
                ->where('is_variation', 0);
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (ProductCategory $productCategory) {
            $productCategory->products()->detach();
        });
    }
}
