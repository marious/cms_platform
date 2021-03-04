<?php

namespace EG\Hospital\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Doctor extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'hs_doctors';

    protected $fillable = [
        'name',
        'status',
        'description',
        'image',
        'phone',
        'mobile',
        'department_id',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault();
    }
}
