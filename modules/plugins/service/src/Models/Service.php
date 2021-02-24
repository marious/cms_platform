<?php

namespace EG\Service\Models;

use EG\Base\Traits\EnumCastable;
use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;

class Service extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'description',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
