<?php

namespace EG\Contact\Repositories\Caches;

use EG\Contact\Repositories\Interfaces\ContactReplyInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class ContactReplyCacheDecorator extends CacheAbstractDecorator implements ContactReplyInterface
{
}
