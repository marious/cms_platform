<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ProductCollection extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_product_collections';

    protected $fillable = [
        'name',
//        'slug',
        'description',
        'image',
        'status',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];


    protected static function boot()
    {
        parent::boot();

//        self::deleting(function (ProductCollection $collection) {
//           $collection->discounts()->detach();
//        });
    }

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Product::class,
                'ec_product_collection_products',
                'product_collection_id',
                'product_id'
            )
            ->where('is_variation', 0);
    }
}
