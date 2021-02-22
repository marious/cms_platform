<?php

namespace EG\Ecommerce\Http\Controllers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Ecommerce\Forms\ProductAttributeSetForm;
use EG\Ecommerce\Http\Requests\ProductAttributeSetsRequest;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use EG\Ecommerce\Services\ProductAttributes\StoreAttributeSetService;
use EG\Ecommerce\Tables\ProductAttributeSetsTable;
use Assets2;
use Exception;
use Illuminate\Http\Request;

class ProductAttributeSetsController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var ProductAttributeSetInterface
     */
    protected $productAttributeSetRepository;

    /**
     * @var ProductCategoryInterface
     */
    protected $productCategoryRepository;


    public function __construct(
        ProductAttributeSetInterface $productAttributeSetRepository,
        ProductCategoryInterface $productCategoryRepository
    )
    {
        $this->productAttributeSetRepository = $productAttributeSetRepository;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(ProductAttributeSetsTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::product-attributes.name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::product-attributes.create'));

        Assets2::addScripts(['spectrum', 'jquery-ui'])
                ->addStyles(['spectrum'])
                ->addStylesDirectly([
                    asset('vendor/core/plugins/ecommerce/css/ecommerce-product-attributes.css'),
                ])
                ->addScriptsDirectly([
                    asset('vendor/core/plugins/ecommerce/js/ecommerce-product-attributes.js'),
                ]);

        return $formBuilder->create(ProductAttributeSetForm::class)->renderForm();
    }

    public function store(
        ProductAttributeSetsRequest $request,
        StoreAttributeSetService $service,
        BaseHttpResponse $response
    )
    {
        $productAttributeSet = $this->productAttributeSetRepository->getModel();

        $productAttributeSet = $service->execute($request, $productAttributeSet);

        event(new CreatedContentEvent(PRODUCT_ATTRIBUTE_SETS_MODULE_SCREEN_NAME, $request, $productAttributeSet));

        return $response
            ->setPreviousUrl(route('product-attribute-sets.index'))
            ->setNextUrl(route('product-attribute-sets.edit', $productAttributeSet->id))
            ->setMessage(trans('core/base::notices.create_success_message'));

    }

    public function edit($id, FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::product-attributes.edit'));

        $productAttributeSet = $this->productAttributeSetRepository->findOrFail($id);

        Assets2::addScripts(['spectrum', 'jquery-ui'])
            ->addStyles(['spectrum'])
            ->addStylesDirectly([
                'vendor/core/plugins/ecommerce/css/ecommerce-product-attributes.css',
            ])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/js/ecommerce-product-attributes.js',
            ]);

        return $formBuilder
            ->create(ProductAttributeSetForm::class, ['model' => $productAttributeSet])
            ->renderForm();
    }

    public function update(
        $id,
        ProductAttributeSetsRequest $request,
        StoreAttributeSetService $service,
        BaseHttpResponse $response
    )
    {
        $productAttributeSet = $this->productAttributeSetRepository->findOrFail($id);

        $service->execute($request, $productAttributeSet);

        event(new UpdatedContentEvent(PRODUCT_ATTRIBUTE_SETS_MODULE_SCREEN_NAME, $request, $productAttributeSet));

        return $response
            ->setPreviousUrl(route('product-attribute-sets.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $productAttributeSet = $this->productAttributeSetRepository->findOrFail($id);
            $this->productAttributeSetRepository->delete($productAttributeSet);

            event(new DeletedContentEvent(PRODUCT_ATTRIBUTE_SETS_MODULE_SCREEN_NAME, $request, $productAttributeSet));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->productAttributeSetRepository, PRODUCT_ATTRIBUTE_SETS_MODULE_SCREEN_NAME);
    }
}
