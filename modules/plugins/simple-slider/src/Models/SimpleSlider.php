<?php
namespace EG\SimpleSlider\Models;

use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;

class SimpleSlider extends BaseModel
{
    use EnumCastable;

    protected $table = 'simple_sliders';

    protected $fillable = [
        'name',
        'key',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function sliderItems()
    {
        return $this->hasMany(SimpleSliderItem::class)->orderBy('simple_slider_items.order', 'asc');
    }

    protected static function boot()
    {
        parent::boot();
        self::deleting(function (SimpleSlider $slider) {
            SimpleSliderItem::where('simple_slider_id', $slider->id)->delete();
        });
    }
}
