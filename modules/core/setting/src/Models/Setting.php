<?php
namespace EG\Setting\Models;

use EG\Base\Models\BaseModel;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $fillable = [
      'key',
      'value',
    ];

    public $timestamps = false;
}
