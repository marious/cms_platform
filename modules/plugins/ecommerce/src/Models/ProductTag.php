<?php

namespace EG\Ecommerce\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ProductTag extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_product_tags';

    protected $fillable = [
        'name',
        'status',
        'description',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'ec_product_tag_product', 'tag_id', 'product_id')
            ->where('is_variation', 0);
    }

//    public function sluggable(): array
//    {
//        return [
//            'slug' => [
//                'source' => 'name',
//            ]
//        ];
//    }
//
//    public function getRouteKeyName()
//    {
//        return 'slug';
//    }
}
