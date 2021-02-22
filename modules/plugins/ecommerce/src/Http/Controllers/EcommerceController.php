<?php

namespace EG\Ecommerce\Http\Controllers;

use Assets2;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Supports\Helper;
use EG\Ecommerce\Http\Requests\StoreLocatorRequest;
use EG\Ecommerce\Http\Requests\UpdateSettingsRequest;
use EG\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use EG\Ecommerce\Repositories\Interfaces\StoreLocatorInterface;
use EG\Ecommerce\Services\StoreCurrenciesService;
use EG\Setting\Supports\SettingStore;
use Illuminate\Http\Request;

class EcommerceController extends BaseController
{

    /**
     * @var StoreLocatorInterface
     */
    protected $storeLocatorRepository;

    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    public function __construct(StoreLocatorInterface $storeLocatorRepository, CurrencyInterface $currencyRepository)
    {
        $this->storeLocatorRepository = $storeLocatorRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function getSettings()
    {
        page_title()->setTitle(trans('plugins/ecommerce::ecommerce.settings'));

        Assets2::addScripts(['jquery-ui'])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/js/currencies.js',
                'vendor/core/plugins/ecommerce/js/setting.js',
                'vendor/core/plugins/ecommerce/js/store-locator.js',
            ])
            ->addStylesDirectly([
                'vendor/core/plugins/ecommerce/css/ecommerce.css',
                'vendor/core/plugins/ecommerce/css/currencies.css',
            ]);

        $currencies = $this->currencyRepository
            ->getAllCurrencies()
            ->toArray();

        $storeLocators = $this->storeLocatorRepository->all();

        return view('plugins/ecommerce::settings.index', compact('currencies', 'storeLocators'));

    }

    public function postSettings(
        UpdateSettingsRequest $request,
        BaseHttpResponse $response,
        StoreCurrenciesService $service,
        SettingStore $settingStore
    )
    {
        foreach ($request->except(['_token', 'currencies', 'deleted_currencies']) as $settingKey => $settingValue) {
            $settingStore->set(config('plugins.ecommerce.general.prefix') . $settingKey, $settingValue);
        }

        $settingStore->save();

        $primaryStore = $this->storeLocatorRepository->getFirstBy(['is_primary' => 1]);

        if (!$primaryStore) {
            $primaryStore = $this->storeLocatorRepository->getModel();
            $primaryStore->is_primary = true;
            $primaryStore->is_shipping_location = true;
        }


        $primaryStore->name = $primaryStore->name ?? __('Default store');
        $primaryStore->phone = $request->input('store_phone');
        $primaryStore->email = $primaryStore->email ?? $settingStore->get('admin_email');
        $primaryStore->address = $request->input('store_address');
        $primaryStore->country = $request->input('store_country');
        $primaryStore->state = $request->input('store_state');
        $primaryStore->city = $request->input('store_city');
        $this->storeLocatorRepository->createOrUpdate($primaryStore);

        $currencies = json_decode($request->input('currencies'), true) ?: [];
        $deletedCurrencies = json_decode($request->input('deleted_currencies', []), true) ?: [];

        $service->execute($currencies, $deletedCurrencies);

        return $response
            ->setNextUrl(route('ecommerce.settings'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function getStoreLocatorForm(BaseHttpResponse $response, $id = null)
    {
        $locator = null;
        if ($id) {
            $locator = $this->storeLocatorRepository->findOrFail($id);
        }

        return $response->setData(view('plugins/ecommerce::settings.store-locator-item', compact('locator'))->render());
    }


    public function postUpdateStoreLocator(
        $id,
        StoreLocatorRequest $request,
        BaseHttpResponse $response,
        SettingStore $settingStore
    )
    {
        $request->merge([
            'is_shipping_location' => $request->has('is_shipping_location'),
        ]);

        $locator = $this->storeLocatorRepository->createOrUpdate($request->input(), compact('id'));

        if ($locator->is_primary) {
            $settingStore
                ->set([
                    config('plugins.ecommerce.general.prefix') . 'store_phone'   => $locator->phone,
                    config('plugins.ecommerce.general.prefix') . 'store_address' => $locator->address,
                    config('plugins.ecommerce.general.prefix') . 'store_country' => $locator->country,
                    config('plugins.ecommerce.general.prefix') . 'store_state'   => $locator->state,
                    config('plugins.ecommerce.general.prefix') . 'store_city'    => $locator->city,
                ])
                ->save();
        }

        return $response->setMessage(trans('core/base::notices.update_success_message'));

    }



    public function postCreateStoreLocator(StoreLocatorRequest $request, BaseHttpResponse $response)
    {
        $request->merge([
            'is_primary'                => false,
            'is_shipping_location'      => $request->has('is_shipping_location'),
            'country'                   => $request->store_country,
        ]);

        $this->storeLocatorRepository->createOrUpdate($request->input());

        return $response->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function postDeleteStoreLocator($id, BaseHttpResponse $response)
    {
        $this->storeLocatorRepository->deleteBy(compact('id'));

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function postUpdatePrimaryStore(Request $request, BaseHttpResponse $response)
    {
        $this->storeLocatorRepository->update([], ['is_primary' => false]);
        $this->storeLocatorRepository->createOrUpdate(['is_primary' => true], ['id' => $request->input('primary_store_id')]);

        return $response->setMessage(trans('core/base::notices.update_success_message'));
    }



    public function ajaxGetCountries(BaseHttpResponse $response)
    {
        return $response->setData(Helper::countries());
    }


}
