<?php
namespace EG\ACL\Models;

use EG\Base\Models\BaseModel;

class Activation extends BaseModel
{
      /**
       * {@inheritDoc}
       */
      protected $fillable = [
        'code',
        'completed',
        'completed_at',
    ];

      /**
       * @var array
       */
      protected $casts = [
        'completed' => 'bool',
    ];
}
