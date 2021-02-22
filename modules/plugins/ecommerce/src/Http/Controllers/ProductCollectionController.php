<?php

namespace EG\Ecommerce\Http\Controllers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Ecommerce\Forms\ProductCollectionForm;
use EG\Ecommerce\Http\Requests\ProductCollectionRequest;
use EG\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use EG\Ecommerce\Tables\ProductCollectionTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProductCollectionController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var ProductCollectionInterface
     */
    protected $productCollectionRepository;

    /**
     * ProductCollectionController constructor.
     * @param ProductCollectionInterface $productCollectionRepository
     */
    public function __construct(ProductCollectionInterface $productCollectionRepository)
    {
        $this->productCollectionRepository = $productCollectionRepository;
    }

    /**
     * @param ProductCollectionTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(ProductCollectionTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::product-collections.name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::product-collections.create'));

        return $formBuilder->create(ProductCollectionForm::class)->renderForm();
    }

    /**
     * @param ProductCollectionRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ProductCollectionRequest $request, BaseHttpResponse $response)
    {
        $productCollection = $this->productCollectionRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(PRODUCT_COLLECTION_MODULE_SCREEN_NAME, $request, $productCollection));

        return $response
            ->setPreviousUrl(route('product-collections.index'))
            ->setNextUrl(route('product-collections.edit', $productCollection->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $productCollection = $this->productCollectionRepository->findOrFail($id);
        page_title()->setTitle(trans('plugins/ecommerce::product-collections.edit') . ' "' . $productCollection->name . '"');

        return $formBuilder
            ->create(ProductCollectionForm::class, ['model' => $productCollection])
//            ->remove('slug')
            ->renderForm();
    }

    /**
     * @param int $id
     * @param ProductCollectionRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ProductCollectionRequest $request, BaseHttpResponse $response)
    {
        $productCollection = $this->productCollectionRepository->findOrFail($id);
        $productCollection->fillMultiLang($request->input());

        $this->productCollectionRepository->createOrUpdate($productCollection);
        event(new UpdatedContentEvent(PRODUCT_COLLECTION_MODULE_SCREEN_NAME, $request, $productCollection));

        return $response
            ->setPreviousUrl(route('product-collections.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        $productCollection = $this->productCollectionRepository->findOrFail($id);

        try {
            $this->productCollectionRepository->delete($productCollection);
            event(new DeletedContentEvent(PRODUCT_COLLECTION_MODULE_SCREEN_NAME, $request, $productCollection));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->productCollectionRepository, PRODUCT_COLLECTION_MODULE_SCREEN_NAME);
    }

    /**
     * @param BaseHttpResponse $response
     * @return mixed
     */
    public function getListForSelect(BaseHttpResponse $response)
    {
        $productCollections = $this->productCollectionRepository
            ->getModel()
            ->select(['id', 'name'])
            ->get()
            ->toArray();

        return $response->setData($productCollections);
    }
}
