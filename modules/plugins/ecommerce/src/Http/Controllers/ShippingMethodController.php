<?php

namespace EG\Ecommerce\Http\Controllers;

use Assets2;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Supports\Helper;
use EG\Ecommerce\Forms\AddShippingRegionForm;
use EG\Ecommerce\Http\Requests\AddShippingRegionRequest;
use EG\Ecommerce\Http\Requests\ShippingRuleRequest;
use EG\Ecommerce\Repositories\Interfaces\ShippingInterface;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleInterface;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleItemInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ShippingMethodController extends BaseController
{
    /**
     * @var ShippingInterface
     */
    protected $shippingRepository;

    /**
     * @var ShippingRuleInterface
     */
    protected $shippingRuleRepository;

    /**
     * @var ShippingRuleInterface
     */
    protected $shippingRuleItemRepository;


    public function __construct(
        ShippingInterface $shippingRepository,
        ShippingRuleInterface $shippingRuleRepository,
        ShippingRuleItemInterface $shippingRuleItemRepository
    )
    {
        $this->shippingRepository = $shippingRepository;
        $this->shippingRuleRepository = $shippingRuleRepository;
        $this->shippingRuleItemRepository = $shippingRuleItemRepository;
    }


    public function index()
    {
        page_title()->setTitle(trans('plugins/ecommerce::shipping.shipping_methods'));

        Assets2::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScriptsDirectly(['vendor/core/plugins/ecommerce/js/shipping.js'])
            ->addScripts(['input-mask']);

        $shipping = $this->shippingRepository->allBy([], ['rules']);

        return view('plugins/ecommerce::shipping.methods', compact('shipping'));
    }


    public function getCreateRegion(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AddShippingRegionForm::class,
            ['url' => route('shipping_methods.region.create.post')]);

        $existedCountries = $this->shippingRepository->pluck('country');

        foreach ($existedCountries as &$existedCountry) {
            if (empty($existedCountry)) {
                $existedCountry = '';
            }
        }

        $countries = ['' => __('All')] + Helper::countries();

        $countries = array_diff_key($countries, array_flip($existedCountries));

        $form->getField('region')
            ->setOption('choices', $countries);

        return $form->setUseInlineJs(true)->renderForm();
    }

    public function postCreateRegion(AddShippingRegionRequest $request, BaseHttpResponse $response)
    {
        $country = $request->input('region');
        $shipping = $this->shippingRepository->createOrUpdate([
            'title'       => $country ? $country : __('All'),
            'country'     => $request->input('region') ?? null,
            'currency_id' => get_application_currency_id(),
        ]);

        if (!$shipping) {
            return $response
                ->setError()
                ->setMessage(__('There is an error when adding new region!'));
        }

        $default = $this->shippingRepository
            ->getModel()
            ->whereNull('country')
            ->join('ec_shipping_rules', 'ec_shipping_rules.shipping_id', 'ec_shipping.id')
            ->select(['ec_shipping_rules.from', 'ec_shipping_rules.to', 'ec_shipping_rules.price'])
            ->first();

        $from = 0;
        $to = null;
        $price = 0;
        if ($default) {
            $from = $default->from;
            $to = $default->to;
            $price = $default->price;
        }

        $this->shippingRuleRepository->createOrUpdate([
            'name'        => __('Delivery'),
            'type'        => 'base_on_price',
            'price'       => $price,
            'from'        => $from,
            'to'          => $to,
            'shipping_id' => $shipping->id,
        ]);

        return $response->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function deleteRegion(Request $request, BaseHttpResponse $response)
    {
        $shipping = $this->shippingRepository->findOrFail($request->input('id'));
        $this->shippingRepository->delete($shipping);
        $this->shippingRuleRepository->deleteBy(['shipping_id' => $shipping->id]);
        event(new DeletedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function deleteRegionRule(Request $request, BaseHttpResponse $response)
    {
        $rule = $this->shippingRuleRepository->findOrFail($request->input('id'));
        $this->shippingRuleRepository->delete($rule);

        $ruleCount = $this->shippingRuleRepository->count(['shipping_id' => $rule->shipping_id]);

        if ($ruleCount === 0) {
            $shipping = $this->shippingRepository->findOrFail($rule->shipping_id);
            $this->shippingRepository->delete($shipping);
            event(new DeletedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'))->setData([
            'count'       => $ruleCount,
            'shipping_id' => $rule->shipping_id,
        ]);
    }

    public function putUpdateRule($id, ShippingRuleRequest $request, BaseHttpResponse $response)
    {
        $this->shippingRuleRepository->createOrUpdate($request->input(), compact('id'));

        $this->shippingRuleItemRepository->deleteBy(['shipping_rule_id' => $id]);

        foreach ($request->input('shipping_rule_items', []) as $key => $item) {
            if (Arr::get($item, 'is_enabled', 0) == 0 || Arr::get($item, 'adjustment_price', 0) != 0) {
                $this->shippingRuleItemRepository->createOrUpdate([
                    'shipping_rule_id' => $id,
                    'city'             => $key,
                    'adjustment_price' => Arr::get($item, 'adjustment_price', 0),
                    'is_enabled'       => Arr::get($item, 'is_enabled', 0),
                ]);
            }
        }

        return $response->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function postCreateRule(ShippingRuleRequest $request, BaseHttpResponse $response)
    {
        $rule = $this->shippingRuleRepository->createOrUpdate($request->input());
        $shipping_item = $this->shippingRepository->findById($rule->shipping_id);
        $data = view('plugins/ecommerce::shipping.rule-item', compact('rule', 'shipping_item'))->render();

        return $response
            ->setMessage(trans('core/base::notices.create_success_message'))
            ->setData($data);
    }
}
