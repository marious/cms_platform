<?php
namespace EG\Ecommerce\Services;

use EG\Ecommerce\Repositories\Interfaces\CurrencyInterface;

class StoreCurrenciesService
{
    protected $currencyRepository;

    public function __construct(CurrencyInterface $currency)
    {
        $this->currencyRepository = $currency;
    }

    public function execute(array $currencies, array $deletedCurrencies)
    {
        if ($deletedCurrencies) {
            $this->currencyRepository->deleteBy([
                ['id', 'IN', $deletedCurrencies],
            ]);
        }

        foreach ($currencies as $item) {
            $currency = $this->currencyRepository->findById($item['id']);
            if (!$currency) {
                $this->currencyRepository->create($item);
            } else {
                $currency->fill($item);
                $this->currencyRepository->createOrUpdate($currency);
            }
        }
    }
}
