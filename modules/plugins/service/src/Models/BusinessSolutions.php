<?php

namespace EG\Service\Models;

use EG\Base\Traits\EnumCastable;
use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Slug\Traits\SlugTrait;

class BusinessSolutions extends BaseModel
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_solutions';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'description',
        'content',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
