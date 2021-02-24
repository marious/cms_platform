<?php

namespace EG\Service\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Service\Http\Requests\ServiceRequest;
use EG\Service\Repositories\Interfaces\ServiceInterface;
use EG\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use EG\Service\Tables\ServiceTable;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Service\Forms\ServiceForm;
use EG\Base\Forms\FormBuilder;

class ServiceController extends BaseController
{
    /**
     * @var ServiceInterface
     */
    protected $serviceRepository;

    /**
     * @param ServiceInterface $serviceRepository
     */
    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @param ServiceTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(ServiceTable $table)
    {
        page_title()->setTitle(trans('plugins/service::service.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/service::service.create'));

        return $formBuilder->create(ServiceForm::class)->renderForm();
    }

    /**
     * @param ServiceRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ServiceRequest $request, BaseHttpResponse $response)
    {
        $service = $this->serviceRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $service));

        return $response
            ->setPreviousUrl(route('service.index'))
            ->setNextUrl(route('service.edit', $service->id))
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
        $service = $this->serviceRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $service));

        page_title()->setTitle(trans('plugins/service::service.edit') . ' "' . $service->name . '"');

        return $formBuilder->create(ServiceForm::class, ['model' => $service])->renderForm();
    }

    /**
     * @param $id
     * @param ServiceRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ServiceRequest $request, BaseHttpResponse $response)
    {
        $service = $this->serviceRepository->findOrFail($id);

        $service->fill($request->input());

        $this->serviceRepository->createOrUpdate($service);

        event(new UpdatedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $service));

        return $response
            ->setPreviousUrl(route('service.index'))
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
            $service = $this->serviceRepository->findOrFail($id);

            $this->serviceRepository->delete($service);

            event(new DeletedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $service));

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
            $service = $this->serviceRepository->findOrFail($id);
            $this->serviceRepository->delete($service);
            event(new DeletedContentEvent(SERVICE_MODULE_SCREEN_NAME, $request, $service));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
