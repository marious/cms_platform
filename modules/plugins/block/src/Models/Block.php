<?php

namespace EG\Block\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Traits\EnumCastable;
use EG\Base\Models\BaseModel;

class Block extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blocks';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
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
