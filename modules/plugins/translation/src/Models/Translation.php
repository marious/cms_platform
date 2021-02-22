<?php
namespace EG\Translation\Models;

use EG\Base\Models\BaseModel;

class Translation extends BaseModel
{
    const STATUS_SAVED = 0;
    const STATUS_CHANGED = 1;

    protected $table = 'translations';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function scopeOfTranslatedGroup($query, $group)
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    public function scopeOrderByGroupKeys($query, $ordered)
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup($query)
    {
        switch (config('database.default')) {
            case 'mysql':
                $select = 'DISTINCT `group`';
                break;
            default:
                $select = 'DISTINCT "group"';
                break;
        }

        return $query->select(DB::raw($select));
    }

}
