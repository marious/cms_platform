<?php
namespace EG\Blog\Models;

use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use EG\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Exception;
use Spatie\Translatable\HasTranslations;

class Tag extends BaseModel
{
    use EnumCastable;

    protected $fillable = [
        'name',
        'description',
        'status',
        'author_id',
    ];


    protected $casts = [
        'status'  => BaseStatusEnum::class,
    ];


    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Tag $tag) {
          $tag->posts()->detach();
        });
    }
}
