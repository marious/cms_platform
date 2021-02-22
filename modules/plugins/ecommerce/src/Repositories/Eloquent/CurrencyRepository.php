<?php

namespace EG\Ecommerce\Repositories\Eloquent;

use EG\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;

class CurrencyRepository extends RepositoriesAbstract implements CurrencyInterface
{

    public function getAllCurrencies()
    {
        $data = $this->model
                    ->orderBy('order', 'ASC')
                    ->get();

        $this->resetModel();

        return $data;
    }
}
