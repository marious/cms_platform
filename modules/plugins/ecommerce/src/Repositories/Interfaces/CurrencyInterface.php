<?php

namespace EG\Ecommerce\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface CurrencyInterface extends RepositoryInterface
{
    public function getAllCurrencies();
}
