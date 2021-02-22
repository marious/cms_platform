<?php

namespace EG\Slug\Models;

use EG\Base\Models\BaseModel;
use Spatie\Translatable\HasTranslations;

class Slug extends BaseModel
{
    use HasTranslations;

    protected $table = 'slugs';

    public $translatable = ['key'];

    protected $fillable = [
        'key',
        'reference_type',
        'reference_id',
        'prefix',
    ];


    public function reference()
    {
        return $this->morphTo();
    }
}
