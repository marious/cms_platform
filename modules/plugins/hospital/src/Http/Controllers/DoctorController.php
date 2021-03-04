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
use EG\Hospital\Forms\DepartmentForm;
use EG\Hospital\Forms\DoctorForm;
use EG\Hospital\Http\Requests\DepartmentRequest;
use EG\Hospital\Http\Requests\DoctorRequest;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Hospital\Repositories\Interfaces\DoctorInterface;
use EG\Hospital\Tables\DepartmentTable;
use EG\Hospital\Tables\DoctorTable;
use Illuminate\Http\Request;
use Exception;

class DoctorController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $doctorRepository;

    public function __construct(DoctorInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function index(DoctorTable $table)
    {
        page_title()->setTitle(trans('plugins/hospital::hospital.doctors'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/hospital::doctor.create'));

        return $formBuilder->create(DoctorForm::class)->renderForm();
    }


    public function store(DoctorRequest $request, BaseHttpResponse $response)
    {
        $department = $this->doctorRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $department));

        return $response
                ->setPreviousUrl(route('doctors.index'))
                ->setNextUrl(route('doctors.edit', $department->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $doctor = $this->doctorRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $doctor));

        page_title()->setTitle(trans('plugins/hospital::department.edit') . ' " ' . $doctor->name . '"');

        return $formBuilder->create(DoctorForm::class, ['model' => $doctor])->renderForm();
    }

    public function update($id, DoctorRequest $request, BaseHttpResponse $response)
    {
        $doctor = $this->doctorRepository->findOrFail($id);
        $doctor->fillMultiLang($request->input());
        $this->doctorRepository->createOrUpdate($doctor);
        event(new UpdatedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $doctor));  // This event will go to make slug

        return $response
                ->setPreviousUrl(route('doctors.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $department = $this->departmentRepository->findOrFail($id);
            $this->departmentRepository->delete($department);
            event(new DeletedContentEvent(HOSPITAL_DOCTOR_MODULE_SCREEN_NAME, $request, $department));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $this->executeDeleteItems($request, $response, $this->departmentRepository, HOSPITAL_DOCTOR_MODULE_SCREEN_NAME);
    }
}
