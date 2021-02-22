<?php
namespace EG\Language\Models;

use EG\Base\Models\BaseModel;


class LanguageMeta extends BaseModel
{
    protected $table = 'language_meta';

    protected $primaryKey = 'lang_meta_id';

    protected $fillable = [
        'lang_meta_code',
        'lang_meta_origin',
        'reference_id',
        'reference_type',
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
