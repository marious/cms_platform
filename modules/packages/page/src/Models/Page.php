<?php
namespace EG\Page\Models;

use EG\ACL\Models\User;
use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use EG\Revision\RevisionableTrait;

class Page extends BaseModel
{
    use RevisionableTrait;
    use EnumCastable;

    protected $table = 'pages';

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    protected $revisionEnabled = true;

    protected $revisionCleanup = true;

    protected $historyLimit = 20;

    protected $dontKeepRevisionOf = ['content'];


    protected $fillable = [
        'name',
        'content',
        'image',
        'template',
        'description',
        'is_featured',
        'status',
        'user_id',
    ];

    public function user()
    {
        $this->belongsTo(User::class)->withDefault();
    }
}
