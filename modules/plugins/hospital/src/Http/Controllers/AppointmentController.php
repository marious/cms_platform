<?php

namespace EG\Hospital\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Hospital\Forms\AppointmentForm;
use EG\Hospital\Forms\DepartmentForm;
use EG\Hospital\Http\Requests\DepartmentRequest;
use EG\Hospital\Repositories\Interfaces\AppointmentInterface;
use EG\Hospital\Tables\DepartmentTable;
use Illuminate\Http\Request;
use Exception;
use Assets2;

class AppointmentController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $appointmentRepository;

    public function __construct(AppointmentInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index(DepartmentTable $table)
    {
        page_title()->setTitle(trans('plugins/hospital::hospital.departments'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/hospital::appointment.create'));

        Assets2::addScripts(['moment', 'datetimepicker'])
                ->addStyles(['datetimepicker'])
                ->addScriptsDirectly([
                    'vendor/core/plugins/hospital/js/hospital.js',
                ]);


        return $formBuilder->create(AppointmentForm::class)->renderForm();
    }


    public function store(DepartmentRequest $request, BaseHttpResponse $response)
    {
        $department = $this->departmentRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));

        return $response
                ->setPreviousUrl(route('departments.index'))
                ->setNextUrl(route('departments.edit', $department->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $department = $this->departmentRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $department));

        page_title()->setTitle(trans('plugins/hospital::department.edit') . ' " ' . $department->name . '"');

        return $formBuilder->create(DepartmentForm::class, ['model' => $department])->renderForm();
    }

    public function update($id, DepartmentRequest $request, BaseHttpResponse $response)
    {
        $department = $this->departmentRepository->findOrFail($id);
        $department->fillMultiLang($request->input());
        $this->departmentRepository->createOrUpdate($department);
        event(new UpdatedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));  // This event will go to make slug

        return $response
                ->setPreviousUrl(route('departments.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $department = $this->departmentRepository->findOrFail($id);
            $this->departmentRepository->delete($department);
            event(new DeletedContentEvent(HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME, $request, $department));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $this->executeDeleteItems($request, $response, $this->departmentRepository, HOSPITAL_DEPARTMENT_MODULE_SCREEN_NAME);
    }
}
