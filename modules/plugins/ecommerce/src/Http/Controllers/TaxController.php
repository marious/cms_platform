<?php

namespace EG\Ecommerce\Http\Controllers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Ecommerce\Forms\TaxForm;
use EG\Ecommerce\Http\Requests\TaxRequest;
use EG\Ecommerce\Repositories\Interfaces\TaxInterface;
use EG\Ecommerce\Tables\TaxTable;
use Exception;
use Illuminate\Http\Request;

class TaxController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var TaxInterface
     */
    protected $taxRepository;

    public function __construct(TaxInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function index(TaxTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::tax.name'));
        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::tax.create'));

        return $formBuilder->create(TaxForm::class)->renderForm();
    }

    public function store(TaxRequest $request, BaseHttpResponse $response)
    {
        $tax = $this->taxRepository->createOrUpdate($request->input());
        event(new CreatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setNextUrl(route('tax.edit', $tax->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit($id, FormBuilder $formBuilder)
    {
        $tax = $this->taxRepository->findOrFail($id);
        page_title()->setTitle(trans('plugins/ecommerce::tax.edit', ['title' => $tax->title]));

        return $formBuilder->create(TaxForm::class, ['model' => $tax])->renderForm();
    }

    public function update($id, TaxRequest $request, BaseHttpResponse $response)
    {
        $tax = $this->taxRepository->createOrUpdate($request->input(), ['id' => $id]);

        event(new UpdatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $tax = $this->taxRepository->findOrFail($id);
            $this->taxRepository->delete($tax);
            event(new DeletedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->taxRepository, TAX_MODULE_SCREEN_NAME);
    }
}
