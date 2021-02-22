<?php
namespace EG\Widget\Models;

use EG\Base\Models\BaseModel;

class Widget extends BaseModel
{
    protected $table = 'widgets';


    protected $fillable = [
        'widget_id',
        'sidebar_id',
        'theme',
        'position',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];
}
