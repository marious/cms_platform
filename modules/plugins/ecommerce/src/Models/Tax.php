<?php

namespace EG\Ecommerce\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Spatie\Translatable\HasTranslations;

class Tax extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_taxes';

    protected $fillable = [
        'title',
        'percentage',
        'priority',
        'status',
    ];

    public $translatable = ['title'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
