<?php

namespace EG\Ecommerce\Http\Controllers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Ecommerce\Forms\BrandForm;
use EG\Ecommerce\Http\Requests\BrandRequest;
use EG\Ecommerce\Repositories\Interfaces\BrandInterface;
use EG\Ecommerce\Tables\BrandTable;
use Illuminate\Http\Request;
use Exception;

class BrandController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $brandRepository;

    public function __construct(BrandInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(BrandTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::brands.menu'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::brands.create'));

        return $formBuilder->create(BrandForm::class)->renderForm();
    }

    public function store(BrandRequest $request, BaseHttpResponse $response)
    {
        $brand = $this->brandRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

        return $response
            ->setPreviousUrl(route('brands.index'))
            ->setNextUrl(route('brands.edit', $brand->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit($id, FormBuilder $formBuilder)
    {
        $brand = $this->brandRepository->findOrFail($id);
        page_title()->setTitle(trans('plugins/ecommerce::brands.edit') . ' "' . $brand->name . '"');

        return $formBuilder->create(BrandForm::class, ['model' => $brand])->renderForm();
    }

    public function update($id, BrandRequest $request, BaseHttpResponse $response)
    {
        $brand = $this->brandRepository->findOrFail($id);
        $brand->fill($request->input());

        $this->brandRepository->createOrUpdate($brand);

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

        return $response
            ->setPreviousUrl(route('brands.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $brand = $this->brandRepository->findOrFail($id);
            $this->brandRepository->delete($brand);

            event(new DeletedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->brandRepository, BRAND_MODULE_SCREEN_NAME);
    }
}
