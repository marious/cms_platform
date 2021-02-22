<?php

namespace EG\Menu\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;

class Menu extends BaseModel
{
    use EnumCastable;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function menuNodes()
    {
        return $this->hasMany(MenuNode::class, 'menu_id');
    }

    public function locations()
    {
        return $this->hasMany(MenuLocation::class, 'menu_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Menu $menu) {
            MenuNode::where('menu_id', $menu->id)->delete();
        });
    }
}
