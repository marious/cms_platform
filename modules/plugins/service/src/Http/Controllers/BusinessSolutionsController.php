<?php

namespace EG\Service\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Service\Http\Requests\ServiceRequest;
use EG\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use EG\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use EG\Service\Tables\BusinessSolutionsTable;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Service\Forms\BusinessSolutionsForm;
use EG\Base\Forms\FormBuilder;

class BusinessSolutionsController extends BaseController
{
    /**
     * @var BusinessSolutionsInterface
     */
    protected $businessSolutionsRepository;

    /**
     * @param BusinessSolutionsInterface $businessSolutionsRepository
     */
    public function __construct(BusinessSolutionsInterface $businessSolutionsRepository)
    {
        $this->businessSolutionsRepository = $businessSolutionsRepository;
    }

    /**
     * @param BusinessSolutionsTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(BusinessSolutionsTable $table)
    {
        page_title()->setTitle(trans('plugins/service::businessSolutions.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/service::businessSolutions.create'));

        return $formBuilder->create(BusinessSolutionsForm::class)->renderForm();
    }

    /**
     * @param ServiceRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ServiceRequest $request, BaseHttpResponse $response)
    {
        $businessSolutions = $this->businessSolutionsRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $businessSolutions));

        return $response
            ->setPreviousUrl(route('business-solutions.index'))
            ->setNextUrl(route('business-solutions.edit', $businessSolutions->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $businessSolutions = $this->businessSolutionsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $businessSolutions));

        page_title()->setTitle(trans('plugins/service::businessSolutions.edit') . ' "' . $businessSolutions->name . '"');

        return $formBuilder->create(BusinessSolutionsForm::class, ['model' => $businessSolutions])->renderForm();
    }

    /**
     * @param $id
     * @param ServiceRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ServiceRequest $request, BaseHttpResponse $response)
    {
        $businessSolutions = $this->businessSolutionsRepository->findOrFail($id);

        $businessSolutions->fill($request->input());

        $this->businessSolutionsRepository->createOrUpdate($businessSolutions);

        event(new UpdatedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $businessSolutions));

        return $response
            ->setPreviousUrl(route('business-solutions.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $businessSolutions = $this->businessSolutionsRepository->findOrFail($id);

            $this->businessSolutionsRepository->delete($businessSolutions);

            event(new DeletedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $businessSolutions));

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
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $businessSolutions = $this->businessSolutionsRepository->findOrFail($id);
            $this->businessSolutionsRepository->delete($businessSolutions);
            event(new DeletedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $businessSolutions));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
