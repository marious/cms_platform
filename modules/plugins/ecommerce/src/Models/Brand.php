<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Spatie\Translatable\HasTranslations;

class Brand extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_brands';

    protected $fillable = [
        'name',
        'website',
        'logo',
        'description',
        'order',
        'is_featured',
        'status',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id')->where('is_variation', 0);
    }
}
