<?php

namespace EG\Ecommerce\Repositories\Caches;

use EG\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use EG\Support\Repositories\Caches\CacheAbstractDecorator;

class CurrencyCacheDecorator extends CacheAbstractDecorator implements CurrencyInterface
{

    public function getAllCurrencies()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
