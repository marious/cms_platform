<?php

namespace EG\Hospital\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class Department extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'hs_departments';

    protected $fillable = [
        'name',
        'status',
        'description',
        'image',
        'content',
    ];

    public $translatable = ['name', 'description', 'content'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class);
    }
}
